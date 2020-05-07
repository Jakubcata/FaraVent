from flask import Flask, jsonify, request

from settings import MQTT_HOST
from client import MQQTClient
from models import Message, Topic


def on_message_callback(topic, message):
    Message.create(type="received", topic=topic, message=message)
    print("saved", topic, message)


topics = [topic.name for topic in Topic.select()]
mqtt_client = MQQTClient(MQTT_HOST, topics, on_message_callback)
mqtt_client.start()

app = Flask(__name__)


@app.route("/topics/list")
def topics():
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/subscribe/")
def subscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.subscribe_topic(topic):
        Topic.create(name=topic)
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/topics/unsubscribe/")
def unsubscribe_topic():
    topic = request.args["topic"]
    if mqtt_client.unsubscribe_topic(topic):
        Topic.get(name=topic).delete_instance()
    return jsonify({"topics": sorted(list(mqtt_client.topics))})


@app.route("/publish/")
def send_message():
    topic = request.args["topic"]
    message = request.args["message"]

    mqtt_client.send_message(topic, message)
    Message.create(type="sent", topic=topic, message=message)
    return jsonify({"topic": topic, "message": message, "status": "sent"})


@app.route("/ping")
def ping():
    return jsonify({"message": "Pong."})


if __name__ == "__main__":
    app.run()
