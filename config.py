import pymysql

DB_HOST = "localhost"
DB_USER = "root"   # Change if needed
DB_PASSWORD = ""   # If you set a password in XAMPP, enter it here
DB_NAME = "nationalpark"

def get_db_connection():
    return pymysql.connect(host=DB_HOST, user=DB_USER, password=DB_PASSWORD, database=DB_NAME)
