# Database-Connection-php-class
A Free Php Database Connection make the querys faster and easyer

Version 1.0 uses Mysqli.
| Code |
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
	
Version 2.0 uses PDO * Work in progress *

The program is free to use.
Help us by forking the program!
