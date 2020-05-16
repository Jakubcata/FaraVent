from datetime import datetime
from sqlalchemy import create_engine, ForeignKey, UniqueConstraint, Sequence
from sqlalchemy import Column, DateTime, Integer, String, JSON, Text
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker, relationship, backref
from settings import DATABASE_URL

engine = create_engine(DATABASE_URL)
Base = declarative_base()

Session = sessionmaker()
Session.configure(bind=engine)
session = Session()


class Message(Base):
    __tablename__ = "message"
    id = Column(Integer, primary_key=True)
    type = Column(String(20), nullable=False)
    topic = Column(String(100), nullable=False)
    message = Column(Text, nullable=False)
    created = Column(DateTime,nullable=False)


class Topic(Base):
    __tablename__ = "topic"
    id = Column(Integer, primary_key=True)
    name = Column(String(100), unique=True, nullable=False)
    created = Column(DateTime, nullable=False)

#Base.metadata.create_all(engine)
