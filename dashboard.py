from flask import Flask, request, jsonify, render_template
import mysql.connector
import pandas as pd
import seaborn as sns
import matplotlib.pyplot as plt
import os
import uuid  # To generate unique graph filenames

app = Flask(__name__)

# MySQL Database Configuration
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'nationalpark'
}

GRAPH_DIR = "static/graphs"
os.makedirs(GRAPH_DIR, exist_ok=True)

@app.route('/')
def home():
    return render_template('dashboard.html')

@app.route('/get_tables', methods=['GET'])
def get_tables():
    """ Fetches all table names from the database """
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SHOW TABLES")
        tables = [table[0] for table in cursor.fetchall()]
        connection.close()
        return jsonify({"tables": tables})
    except Exception as e:
        return jsonify({"error": f"Database error: {str(e)}"}), 500

@app.route('/get_columns', methods=['POST'])
def get_columns():
    """ Fetches column names for a selected table """
    try:
        data = request.get_json()
        table = data.get('table')  # ✅ Fixed: Properly retrieve table name from JSON

        if not table:
            return jsonify({"error": "No table selected"}), 400

        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute(f"SHOW COLUMNS FROM `{table}`")
        columns = [col[0] for col in cursor.fetchall()]
        connection.close()

        if not columns:
            return jsonify({"error": "No columns found"}), 404
        
        return jsonify({"columns": columns})

    except mysql.connector.Error as db_error:
        return jsonify({"error": f"Database error: {str(db_error)}"}), 500
    except Exception as e:
        return jsonify({"error": f"Unexpected error: {str(e)}"}), 500

@app.route('/generate_graph', methods=['POST'])
def generate_graph():
    """ Generates a well-styled graph from database values """
    table = request.form.get('table')
    column = request.form.get('column')
    graph_type = request.form.get('graph_type')
    color = request.form.get('color')

    if not table or not column:
        return jsonify({"error": "Table and column must be provided"}), 400

    # Database Connection
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute(f"SELECT `{column}` FROM `{table}`")
        data = cursor.fetchall()
        connection.close()
    except Exception as e:
        return jsonify({"error": f"Database error: {str(e)}"}), 500

    if not data:
        return jsonify({"error": "No data available for the selected column"}), 404

    # Convert Data to Pandas DataFrame
    df = pd.DataFrame(data, columns=[column])

    # Remove null or non-numeric values
    df = df[pd.to_numeric(df[column], errors='coerce').notna()]

    if df.empty:
        return jsonify({"error": "Column contains non-numeric or null values"}), 400

    # Improve Graph Styling
    plt.figure(figsize=(9, 6))
    sns.set_theme(style="darkgrid")

    if graph_type == 'bar':
        sns.barplot(x=df.index, y=df[column], color=color)
        plt.xticks(rotation=45)
    elif graph_type == 'line':
        sns.lineplot(x=df.index, y=df[column], color=color, marker="o", linewidth=2)
        plt.xticks(rotation=45)
    elif graph_type == 'pie':
        # Ensure valid pie chart data
        if df[column].sum() == 0:
            return jsonify({"error": "Pie chart values sum to zero, invalid chart."}), 400
        plt.pie(df[column], labels=df.index, autopct='%1.1f%%', colors=sns.color_palette("pastel"))

    plt.title(f"{graph_type.capitalize()} Graph of {column}", fontsize=14)
    plt.xlabel("Index")
    plt.ylabel(column)

    # Generate a Unique Graph Path
    graph_filename = f"graph_{uuid.uuid4().hex}.png"
    graph_path = os.path.join(GRAPH_DIR, graph_filename)
    plt.savefig(graph_path, dpi=100, bbox_inches="tight")
    plt.close()

    return jsonify({"graph_path": f"/{graph_path}"})  # Return accessible path

if __name__ == '__main__':
    app.run(debug=True, port=5000)
