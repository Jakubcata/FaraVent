import paho.mqtt.client as mqtt


class MQQTClient:
    def __init__(self, host, topics, on_message_callback):
        self.host = host
        self.topics = set(topics)
        self.client = None
        self.on_message_callback = on_message_callback

    def subscribe_topic(self, topic):
        if not self.client:
            print("MQTT client is not running!")
            return False
        if topic not in self.topics:
            self.topics.add(topic)
            self.client.subscribe(topic)
            print(f"Topic {topic} subscribed")
            return True
        else:
            print(f"Topic {topic} is already subscribed!")
            return False

    def unsubscribe_topic(self, topic):
        if not self.client:
            print("MQTT client is not running!")
            return False
        if topic in self.topics:
            self.topics.remove(topic)
            self.client.unsubscribe(topic)
            print(f"Topic {topic} unsubscribed")
            return True
        else:
            print(f"Topic {topic} is not subscribed!")
            return False

    def on_connect(self, client, userdata, flags, rc):
        """The callback for when the client receives a CONNACK response from the server."""
        print(f"Connected with result code {rc}")

        # Subscribing in on_connect() means that if we lose the connection and
        # reconnect then subscriptions will be renewed.
        for topic in self.topics:
            client.subscribe(topic)
            print(f"Topic {topic} subscribed")

    def on_message(self, client, userdata, msg):
        """The callback for when a PUBLISH message is received from the server."""

        print(f"{msg.topic} {msg.payload}")
        self.on_message_callback(msg.topic, msg.payload)

    def send_message(self, topic, message):
        self.client.publish(topic, message)

    def start(self):

        self.client = mqtt.Client()
        self.client.on_connect = self.on_connect
        self.client.on_message = self.on_message

        self.client.connect(self.host, 1883, 60)

        self.client.loop_start()

    def stop(self):
        self.client.loop_stop()
        self.client = None
