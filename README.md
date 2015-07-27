# Database-Connection-php-class
A Free Php Database Connection make the querys faster and easyer

Version 1.0 uses Mysqli.

	require_once("db.php"); // Require the File
	$dbase = new db();		// Create new Instance
	$dbase->db_connect("hostname", "username", "password", "DatabaseName"); // Connect to a database!
	// Check if the connection is stablished!
	if($dbase->isConnected())
	{
		echo "Connected to database :D";	// Congrats you connected to the database :D
	}
	else
	{
		die("Sorry something went wrong. Erro->".$dbase->getError()); // Kills the page and shows the error
	}
	
	//Making a query
	$results = array(); // We will put the results in this array.
	$results = $dbase->insertQueryReturn("SELECT * FROM `Users`"); 
	
	// If you need to select a table just use this $results = $dbase->getTable("Users");
	// getTable makes the same as "SELECT * FROM `Users`"
	
	echo "<pre>";
	print_r($results);	// Print the results
	echo "</pre>";
	
	$dbase->closeConnection(); // Close the connection with the Database
	
List of all functions

	db_connect(host, user, pass, dbName) # Connect to database Returning (boolean)
	retryConnection() # Retry the connection to the database
	closeConnection() # close the connection return boolean
	changeDb(dbName) # Change the database connection to another
	getError() # Returns the last error occurred on the database
	getDb() # Return Database Name (String)
	isConnected() # Returns if you'r connected to the database (boolean)
	getTable(table) # Returns the table in array
	getColum(table, key, value, limit) # Return the colum in a string
	insertQuery(query) # Inserts a query returning boolean
	insertQueryReturn(query) # Makes a query and Return array with results
	getNumLines(table) # Return number of lines on a table
	getNumLinesSearch(table, key, value) # Return number of lines witg a key = value
	
Version 2.0 uses PDO * Work in progress *

The program is free to use.
Help us by forking the program!
