from flask import Flask, render_template, request, jsonify
import pymysql

app = Flask(__name__)

# Database connection details
DB_HOST = "localhost"
DB_USER = "root"
DB_PASSWORD = ""
DB_NAME = "nationalpark"

# Function to connect to MySQL database
def get_db_connection():
    return pymysql.connect(host=DB_HOST, user=DB_USER, password=DB_PASSWORD, database=DB_NAME)

# Route to render the dashboard
@app.route("/")
def dashboard():
    return render_template("dashboard.html")

# Route to fetch tables from the database
@app.route("/get_tables")
def get_tables():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SHOW TABLES")
    tables = [table[0] for table in cursor.fetchall()]
    connection.close()
    return jsonify(tables)

# Route to fetch columns of a selected table
@app.route("/get_columns", methods=["POST"])
def get_columns():
    table_name = request.form["table"]
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute(f"SHOW COLUMNS FROM `{table_name}`")
    columns = [column[0] for column in cursor.fetchall()]
    connection.close()
    return jsonify(columns)

if __name__ == "__main__":
    app.run(debug=True)
