<?php
		
 $username="root";
	$password="";
	$hostname="localhost";
	$dbname="winestore";
	$dsn="mysql://{$username}:{$password}@{$hostname}/{$dbname}";
	
	//when no database found
	$connection = new DB();
	$connection= @DB::connect($dsn);
	if (@DB::isError($connection)) {
    die("Unable to connect to database: " . $connection->getMessage() . "\n"
                                          . $connection->getDebugInfo() . "\n");
}
?>