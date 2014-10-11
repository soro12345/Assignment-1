<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
include_once("connect.php");

$wine_name = $_GET['wine_name'];
$wine_region = $_GET['wine_region'];
$winery_name= $_GET['winery_name'];
$wine_yearMin= $_GET['wine_yearMin'];
$wine_yearMax= $_GET['wine_yearMax'];
$wine_quantity= $_GET['wine_quantity'];
$wine_purchased= $_GET['wine_purchased'];
$wine_costMin =$_GET['wine_costMin'];
$wine_costMax=$_GET['wine_costMax'];

$winename = preg_replace("#[^0-9a-zA-Z]#i","",$winename);
$wine_region = preg_replace("#[^0-9a-zA-Z]#i","",$wine_region);
$winery_name = preg_replace("#[^0-9a-zA-Z]#i","",$winery_name);
$wine_yearMin = preg_replace("#[^0-9a-zA-Z]#i","",$wine_yearMin);
$wine_yearMax = preg_replace("#[^0-9a-zA-Z]#i","",$wine_yearMax);
$wine_quantity = preg_replace("#[^0-9a-zA-Z]#i","",$wine_quantity);
$wine_purchased = preg_replace("#[^0-9a-zA-Z]#i","",$wine_purchased);
$wine_costMin = preg_replace("#[^0-9a-zA-Z]#i","",$wine_costMin);
$wine_costMax = preg_replace("#[^0-9a-zA-Z]#i","",$wine_costMax);



if(!($result = mysql_query ("SELECT * FROM wine WHERE wine_name LIKE '%$winename%'",$connection)))
		showerror();
		
		
mysql_close($connection);
?>

</body>
</html>
