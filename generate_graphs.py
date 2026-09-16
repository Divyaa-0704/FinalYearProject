import pandas as pd
import matplotlib.pyplot as plt
from db_connection import connect_db

def generate_graph():
    conn = connect_db()
    if conn:
        # Query to get data (modify this as needed)
        query = "SELECT species, COUNT(*) AS count FROM animals GROUP BY species"
        df = pd.read_sql(query, conn)

        # Plot bar chart
        plt.figure(figsize=(8,5))
        plt.bar(df["species"], df["count"], color="skyblue")
        plt.xlabel("Species")
        plt.ylabel("Count")
        plt.title("Animal Species Count")
        plt.xticks(rotation=45)

        # Save graph to a file
        plt.savefig("static/graph.png")  
        plt.show()
        conn.close()

if __name__ == "__main__":
    generate_graph()
