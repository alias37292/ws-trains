# Train Manager Program
Shows a list of trains, which can be either imported via CSV or added individually.

## Installation
1. Create a MySQL database locally or on your server.
2. Run the included **trains.sql** on your database to create the table that will hold train data.
3. Clone this repo into your web root.
4. Change the values in **db.php** to reflect your server hostname, database name, and credentials.

## Usage
* The home page lists trains that are already in the database. You can sort on any column, change page size, or filter using the Search bar.
* To add an individual train, click Add Train.
  NB: If you try to add a train that already exists, you will receive a message stating this.
* To bulk-add trains from CSV, click Import Trains.
  NB: All fields are required. If any fields are blank, you will receive a warning and that train will be skipped.
  NB: If a train exists already, you will receive a warning and that train will be skipped.
* To edit or delete a train, click the Edit button next to the train in question.

## Author Information
Written by Justin Rickman on September 23, 2022.