import enum
from datetime import datetime
from typing import Optional

import pandas as pd


from models import Message, Topic, SensorValues
from sqlalchemy import and_


class StatsResampleFunc(enum.Enum):
    Mean = "mean"
    Max = "max"


class Stats:
    def __init__(self, db):
        self.db = db
        self.db_table = "sensor_values"

    def load_data(
        self,
        device_id: int,
        value: str,
        start_date: datetime,
        end_date: datetime,
        resample: Optional[str] = None,
        resample_func: StatsResampleFunc = StatsResampleFunc.Mean,
    ):
        query = (
            self.db.query(getattr(SensorValues, value), SensorValues.created)
            .filter(
                and_(
                    SensorValues.device_id == device_id,
                    SensorValues.created >= start_date,
                    SensorValues.created <= end_date,
                )
            )
            .statement
        )
        print(query)
        frame = pd.read_sql(query, self.db.bind)

        # set the time index
        frame.index = pd.to_datetime(frame["created"])

        if resample:
            frame = getattr(frame.resample(resample), resample_func.value)()

        return frame
