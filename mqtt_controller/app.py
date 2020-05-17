from datetime import datetime
from flask import Flask, jsonify, request
from flask_cors import CORS

from settings import MQTT_HOST, DATABASE_URL
from client import MQTTClient
from models import Message, Topic, db
import requests


app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = DATABASE_URL
db.init_app(app)


def on_message_callback(topic, message):
    print("Callback", topic, message)
    with app.app_context():
        db.session.add(Message(type="received", topic=topic, message=message, created=datetime.now()))
        db.session.commit()
    print("Saved")

with app.app_context():
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
