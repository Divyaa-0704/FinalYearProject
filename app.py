from flask import Flask, render_template, request, jsonify, send_file
import pandas as pd
import pymysql
import matplotlib.pyplot as plt
import seaborn as sns
import os

# Flask App Initialization
app = Flask(__name__)

# Import Database Configuration
from config import get_db_connection

# Ensure static & exports folder exists for saving graphs & Excel files
os.makedirs("static", exist_ok=True)
os.makedirs("exports", exist_ok=True)

# Function to Get Available Tables from MySQL
def get_available_tables():
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SHOW TABLES;")
    tables = [table[0] for table in cursor.fetchall()]
    conn.close()
    return tables

# Function to Fetch Data from a Table
def fetch_table_data(table_name):
    conn = get_db_connection()
    query = f"SELECT * FROM `{table_name}`;"
    
    try:
        df = pd.read_sql(query, conn)
    except Exception as e:
        print(f"Error fetching data from {table_name}: {e}")
        conn.close()
        return None

    conn.close()
    return df

# Function to Generate Graphs Dynamically
def generate_graph(table_name, graph_type):
    df = fetch_table_data(table_name)
    if df is None or df.empty:
        return None

    plt.figure(figsize=(10, 5))

    # Automatically determine best columns for plotting
    numeric_cols = df.select_dtypes(include=['number']).columns
    categorical_cols = df.select_dtypes(include=['object']).columns

    if len(numeric_cols) >= 2:
        x_col, y_col = numeric_cols[:2]  # Use first two numerical columns
    elif len(numeric_cols) == 1 and len(categorical_cols) >= 1:
        x_col, y_col = categorical_cols[0], numeric_cols[0]
    else:
        return None  # Not enough valid columns for plotting

    # Generate the graph based on type
    if graph_type == "bar":
        sns.barplot(x=df[x_col], y=df[y_col])
    elif graph_type == "line":
        sns.lineplot(x=df[x_col], y=df[y_col])
    elif graph_type == "pie":
        df.groupby(x_col)[y_col].sum().plot(kind="pie", autopct="%1.1f%%")
    else:
        return None

    plt.title(f"{graph_type.capitalize()} Graph for {table_name}")
    plt.xticks(rotation=45)

    graph_path = f"static/{table_name}.png"
    plt.savefig(graph_path)
    plt.close()

    return graph_path

# Function to Export Table Data to Excel
@app.route("/export_to_excel", methods=["POST"])
def export_to_excel():
    table_name = request.form["table"]
    df = fetch_table_data(table_name)

    if df is None:
        return jsonify({"error": "Failed to fetch data"}), 400

    file_path = f"exports/{table_name}.xlsx"
    df.to_excel(file_path, index=False)

    return send_file(file_path, as_attachment=True)

# Route to Display Dashboard
@app.route("/")
def dashboard():
    return render_template("dashboard.html")

# Route to Get Tables List Dynamically
@app.route("/get_tables")
def get_tables():
    tables = get_available_tables()
    return jsonify(tables)

# Route to Generate Graph Based on Table Selection
@app.route("/generate_graph", methods=["POST"])
def fetch_graph():
    table_name = request.form["table"]
    graph_type = request.form["graph_type"]

    graph_path = generate_graph(table_name, graph_type)

    if graph_path:
        return jsonify({"graph_path": graph_path})
    else:
        return jsonify({"error": "Failed to generate graph"}), 400

# Run the Flask App
if __name__ == "__main__":
    app.run(debug=True)
