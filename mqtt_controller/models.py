from flask_sqlalchemy import SQLAlchemy
db = SQLAlchemy()

class Message(db.Model):
    __tablename__ = "message"
    id = db.Column(db.Integer, primary_key=True)
    type = db.Column(db.String(20), nullable=False)
    topic = db.Column(db.String(100), nullable=False)
    message = db.Column(db.Text, nullable=False)
    created = db.Column(db.DateTime,nullable=False)


class Topic(db.Model):
    __tablename__ = "topic"
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), unique=True, nullable=False)
    created = db.Column(db.DateTime, nullable=False)

#db.create_all()
