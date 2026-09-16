import MySQLdb

def connect_db():
    try:
        conn = MySQLdb.connect(
            host="localhost",
            user="root",  # Change if needed
            passwd="",    # XAMPP default has no password
            db="nationalpark"
        )
        print("✅ Database connection successful!")
        return conn
    except MySQLdb.Error as e:
        print(f"❌ Error connecting to database: {e}")
        return None

# Run the function for testing
if __name__ == "__main__":
    connect_db()
