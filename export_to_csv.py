import MySQLdb
import pandas as pd
import os

# MySQL Connection
db = MySQLdb.connect(host="localhost", user="root", passwd="", db="nationalpark")
cursor = db.cursor()

# Create 'exports' folder if not exists
if not os.path.exists("exports"):
    os.makedirs("exports")

# Fetch all tables
cursor.execute("SHOW TABLES")
tables = [table[0] for table in cursor.fetchall()]

# Export each table to CSV
for table in tables:
    df = pd.read_sql(f"SELECT * FROM {table}", db)
    df.to_csv(f"exports/{table}.csv", index=False)
    print(f"Exported: {table}.csv")

cursor.close()
db.close()
print("All tables exported successfully!")
