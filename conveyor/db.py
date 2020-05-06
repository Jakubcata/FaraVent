import mysql.connector
import mysql.connector.pooling

from settings import DB_HOST, DB_DATABASE, DB_PASSWORD, DB_USERNAME


def mysqlpool():
    pool = mysql.connector.pooling.MySQLConnectionPool(
        pool_name="pynative_pool",
        pool_size=30,
        pool_reset_session=True,
        host=DB_HOST,
        user=DB_USERNAME,
        passwd=DB_PASSWORD,
        database=DB_DATABASE,
        auth_plugin="mysql_native_password",
    )
    return pool
