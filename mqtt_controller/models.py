from datetime import datetime
from settings import DB_HOST, DB_DATABASE, DB_PASSWORD, DB_USERNAME
from peewee import MySQLDatabase, Model, DateTimeField, PrimaryKeyField, CharField

db = MySQLDatabase(
    DB_DATABASE,
    host=DB_HOST,
    port=3306,
    user=DB_USERNAME,
    passwd=DB_PASSWORD,
    charset="utf8mb4",
)


class BaseModel(Model):
    created = DateTimeField(default=datetime.now)

    def save(self, *args, no_update_time=False, **kwargs):
        if not no_update_time:
            self.created = datetime.now()
        return super(BaseModel, self).save(*args, **kwargs)

    class Meta:
        database = db


class Message(BaseModel):
    id = PrimaryKeyField()
    type = CharField(max_length=20)
    topic = CharField(max_length=20)
    message = CharField(max_length=200)


class Topic(BaseModel):
    id = PrimaryKeyField()
    name = CharField(max_length=20, unique=True)


db.create_tables([Message, Topic], safe=True)
