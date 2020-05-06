from datetime import datetime
import paho.mqtt.client as mqtt
from db import mysqlpool
from settings import MQTT_HOST, MQTT_TOPICS


class FaraventMQQTClient:
    def __init__(self, mqtt_host, mqtt_topics, db_pool, table_name="received_messages"):
        self.db_pool = db_pool
        self.mqtt_host = mqtt_host
        self.mqtt_topics = mqtt_topics
        self.table_name = table_name

    def on_connect(self, client, userdata, flags, rc):
        """The callback for when the client receives a CONNACK response from the server."""
        print(f"Connected with result code {rc}")

        # Subscribing in on_connect() means that if we lose the connection and
        # reconnect then subscriptions will be renewed.
        for topic in self.mqtt_topics:
            client.subscribe(topic)
            print(f"Topic {topic} subscribed")

    def on_message(self, client, userdata, msg):
        """The callback for when a PUBLISH message is received from the server."""

        print(f"{msg.topic} {msg.payload}")
        cnx = self.db_pool.get_connection()
        cur = cnx.cursor()
        cur.execute(
            f"INSERT INTO {self.table_name} (topic, message, date) VALUES (%s, %s, %s)",
            (msg.topic, msg.payload, datetime.now()),
        )
        cnx.commit()
        cur.close()
        cnx.close()

    def start(self):

        client = mqtt.Client()
        client.on_connect = self.on_connect
        client.on_message = self.on_message

        client.connect(self.mqtt_host, 1883, 60)

        # Blocking call that processes network traffic, dispatches callbacks and
        # handles reconnecting.
        # Other loop*() functions are available that give a threaded interface and a
        # manual interface.
        client.loop_forever()


if __name__ == "__main__":
    client = FaraventMQQTClient(MQTT_HOST, MQTT_TOPICS, mysqlpool())
    client.start()
