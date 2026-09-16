import pandas as pd
import os

# Dictionary of table names and corresponding CSV files
csv_files = {
    'animals': 'animals.csv',
    'donations': 'donations.csv',
    'expenses': 'expenses.csv',
    'maintenance': 'maintenance.csv',
    'nationalparks': 'nationalparks.csv',
    'parkevents': 'parkevents.csv',
    'procurement': 'procurement.csv',
    'rescueoperations': 'rescueoperations.csv',
    'suppliers': 'suppliers.csv',
    'users': 'users.csv'
}

# Loop through each table and read its data
dataframes = {}  # Dictionary to store DataFrames
for table_name, file_path in csv_files.items():
    if os.path.exists(file_path):  # Check if file exists
        df = pd.read_csv(file_path)  # Read CSV instead of Excel
        dataframes[table_name] = df  # Store DataFrame in dictionary
        print(f"Preview of {table_name} table:")
        print(df.head())  # Preview the first few rows
        print("\n-----------------------------------\n")
    else:
        print(f"File {file_path} not found!")

# Now you can access any table’s DataFrame using: dataframes['animals'], dataframes['donations'], etc.
