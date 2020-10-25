from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.dialects.mysql import BIGINT

db = SQLAlchemy()


class Message(db.Model):
    __tablename__ = "message"
    id = db.Column(db.Integer, primary_key=True)
    type = db.Column(db.String(20), nullable=False)
    topic = db.Column(db.String(100), nullable=False)
    message = db.Column(db.Text, nullable=False)
    created = db.Column(db.DateTime, nullable=False)


class Device(db.Model):
    __tablename__ = "devices"
    id = db.Column(BIGINT(unsigned=True), primary_key=True)
    out_topic = db.Column(db.String(255), nullable=False, unique=True)


class SensorValues(db.Model):
    __tablename__ = "sensor_values"
    id = db.Column(db.Integer, primary_key=True)
    device_id = db.Column(
        BIGINT(unsigned=True), db.ForeignKey("devices.id"), nullable=False
    )
    temperature = db.Column(db.Float)
    humidity = db.Column(db.Float)
    movement = db.Column(db.Boolean)
    signal = db.Column(db.Float)
    version = db.Column(db.String(30), nullable=False)
    created = db.Column(db.DateTime, nullable=False)


class Topic(db.Model):
    __tablename__ = "topic"
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), unique=True, nullable=False)
    created = db.Column(db.DateTime, nullable=False)


# db.create_all()
