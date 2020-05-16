from datetime import datetime
from flask import Flask, jsonify, request
from flask_cors import CORS

from settings import MQTT_HOST
from client import MQTTClient
from models import Message, Topic, session
import sqlalchemy
import traceback

def on_message_callback(topic, message):
    print("Callback", topic, message)
    session.add(Message(type="received", topic=topic, message=message, created=datetime.now()))
    session_commit()
    print("Saved")

def session_commit():
    """Handle commit message.

    After an error during commiting, we need to roll it back,
    before we start doing something else.
    """
    try:
        session.commit()
    except sqlalchemy.exc.OperationalError:
        traceback.print_exc()
        session.rollback()

topics = [topic.name for topic in session.query(Topic).all()]
mqtt_client = MQTTClient(MQTT_HOST, topics, on_message_callback)
mqtt_client.start()

app = Flask(__name__)
CORS(app)

@app.route("/topics/list")
def topics():
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/subscribe/")
def subscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.subscribe_topic(topic):
        session.add(Topic(name=topic, created=datetime.now()))
        session_commit()
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/unsubscribe/")
def unsubscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.unsubscribe_topic(topic):
        session.delete(session.query(Topic).filter_by(name=topic).first())
        session_commit()
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/publish/")
def send_message():
    topic = request.args["topic"]
    message = request.args["message"]

    mqtt_client.send_message(topic, message)
    session.add(Message(type="sent", topic=topic, message=message, created=datetime.now()))
    session_commit()
    return jsonify({"topic": topic, "message": message, "status": "sent"})


@app.route("/ping")
def ping():
    return jsonify({"message": "Pong."})


if __name__ == "__main__":
    app.run()
