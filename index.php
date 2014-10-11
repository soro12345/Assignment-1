<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<h1>Search your wine here</h1>
<?php include_once("connect.php"); ?>
<form action="result.php" method="GET">
<table border="1" cellpadding="2">
<tr><td>Wine name: </td><td><input type="text" name="wine_name"></td></tr>
<tr><td>Wine Region: </td><td>
<select name="wine_region">
<?php 
// select region name from region table
if (!($result = mysql_query ("SELECT * FROM region", $connection)))
      showerror();
	  
	  while($temp=mysql_fetch_array($result)){
		  echo "<option value='".$temp["region_name"]."''>";
		  echo $temp["region_name"];
		  echo "</option>\n";
		  
		  
		  }
	  mysql_close($connection);
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
