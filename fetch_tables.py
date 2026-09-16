import os

# Function to list available CSV tables
def get_available_tables():
    return [f[:-4] for f in os.listdir("exports") if f.endswith(".csv")]

# Print tables
tables = get_available_tables()
print("Available tables:", tables)
