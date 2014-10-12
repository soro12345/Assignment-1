<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<h1>Search your wine here</h1>

<form action="result.php" method="get">
<table border="1" cellpadding="2">
<tr><td>Wine name: </td><td><input type="text" name="wine_name"></td></tr>
<tr><td>Wine Region: </td><td>
<select name="wine_region">

<?php 

/*SIR YOU HAVE TO CHANGE BACK THIS TO YOUR DRIVE!!!!!*/
	set_include_path('D:/wamp/wamp/bin/php/php5.4.12/pear');
	require_once "DB.php";
	
include_once("connect.php"); 

// select region name from region table
$query="SELECT * FROM region";
$result = @$connection->query($query);
      
	  
	  $temp = $result->fetchRow();
	  
	  while($temp = $result->fetchRow()){
		  echo "<option value='".$temp[1]."''>";
		  echo $temp[1];
		  echo "</option>\n";
		  
		  
		  }
	$connection->disconnect();
?>
</select></td></tr>
<tr><td>Winery name: </td><td><input type="text" name="winery_name"></td></tr>
<tr><td>Wine years:  </td><td>From: <input type="text" name="wine_yearMin"></td><td>To:<input type="text" name="wine_yearMax"></td></tr>
<tr><td>Minumum number of wines in stock: </td><td><input type="text" name="wine_quantity"></td></tr>
<tr><td>Minumum number of customers who have purchased each wine: </td><td><input type="text" name="wine_purchased"></td></tr>
<tr><td>Cost range: </td><td>Minimum: <input type="text" name="wine_costMin"></td><td>Maximum: <input type="text" name="wine_costMax"></td></tr>
<tr><td></td><td><input type="submit" value="Search"></td></tr>



</table>
</form>

</body>
</html>
