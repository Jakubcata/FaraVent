from datetime import datetime
from flask import Flask, jsonify, request
from flask_cors import CORS

from settings import MQTT_HOST, DATABASE_URL
from client import MQTTClient
from models import Message, Topic, SensorValues, db
import requests
import json


app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = DATABASE_URL
db.init_app(app)

def parse_message(topic, mmessage):
    try:
        json_message = json.loads(mmessage)
        result = db.session.execute("select id from devices where out_topic= :out_topic", {"out_topic": topic})
        device_id = next(result)[0]
        db.session.add(SensorValues(device_id=device_id,
                                    temperature=json_message.get("temp"),
                                    humidity=json_message.get("hum"),
                                    movement=json_message.get("movmnt"),
                                    signal=json_message.get("signl"),
                                    version=json_message.get("version"),
                                    created=datetime.now(),
                                    ))
    except Exception as e:
        print("No device or unable to parse json", e)


def on_message_callback(topic, message):
    print("Callback", topic, message)
    with app.app_context():
        db.session.add(Message(type="received", topic=topic, message=message, created=datetime.now()))
        parse_message(topic, message)
        db.session.commit()
    print("Saved")

with app.app_context():
    #db.create_all()
    topics = [topic.name for topic in db.session.query(Topic).all()]
    mqtt_client = MQTTClient(MQTT_HOST, topics, on_message_callback)
    mqtt_client.start()


@app.route("/topics/list")
def topics():
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/subscribe")
def subscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.subscribe_topic(topic):
        db.session.add(Topic(name=topic, created=datetime.now()))
        db.session.commit()
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/unsubscribe")
def unsubscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.unsubscribe_topic(topic):
        db.session.delete(db.session.query(Topic).filter_by(name=topic).first())
        db.session.commit()
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/publish")
def send_message():
    topic = request.args["topic"]
    message = request.args["message"]

    mqtt_client.send_message(topic, message)
    db.session.add(Message(type="sent", topic=topic, message=message, created=datetime.now()))
    db.session.commit()
    return jsonify({"topic": topic, "message": message, "status": "sent"})


@app.route("/ping")
def ping():
    return jsonify({"message": "Pong."})


if __name__ == "__main__":
    app.run()
