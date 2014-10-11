<?php

//mysqli_close($connection);
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

//remove unwanted characters
$wine_name = preg_replace("#[^0-9a-zA-Z]#i","",$wine_name);
$winery_name = preg_replace("#[^0-9a-zA-Z]#i","",$winery_name);
$wine_yearMin = preg_replace("#[^0-9a-zA-Z]#i","",$wine_yearMin);
$wine_yearMax = preg_replace("#[^0-9a-zA-Z]#i","",$wine_yearMax);
$wine_quantity = preg_replace("#[^0-9a-zA-Z]#i","",$wine_quantity);
$wine_purchased = preg_replace("#[^0-9a-zA-Z]#i","",$wine_purchased);
$wine_costMin = preg_replace("#[^0-9a-zA-Z]#i","",$wine_costMin);
$wine_costMax = preg_replace("#[^0-9a-zA-Z]#i","",$wine_costMax);

	//if one of the field is filled
if($wine_yearMin == "") $wine_yearMin= 0;
if($wine_yearMax == "") $wine_yearMax= 9999;
if($wine_quantity == "")$wine_quantity = 0;
if($wine_purchased == "")$wine_purchased = 0;
if($wine_costMin == "")$wine_costMin = 0; 
if($wine_costMax == "")$wine_costMax = 9999;

		
	// check is the input is number
if((is_numeric($wine_yearMin))&&(is_numeric($wine_yearMax))&&(is_numeric($wine_quantity))&&(is_numeric($wine_purchased))
&&(is_numeric($wine_costMin))&&(is_numeric($wine_costMax)))
	
	{
		if (!($wine_yearMin > $wine_yearMax)){
			 if(!($wine_costMin > $wine_costMax )){
		
			$query = ("SELECT wine.wine_id,wine.wine_name,
							  wine.year,winery.winery_name,
							  region.region_name, wine_variety.variety_id,
							  grape_variety.variety, inventory.cost, inventory.on_hand,
							  COUNT(wine.wine_id) AS custNumber
										
										FROM wine									
										LEFT OUTER JOIN winery
										ON wine.wine_id = winery.winery_id										
										LEFT OUTER JOIN region
										ON winery.region_id = region.region_id										
										LEFT OUTER JOIN wine_variety
										ON wine.wine_id = wine_variety.wine_id										
										LEFT OUTER JOIN grape_variety
										ON wine_variety.variety_id = grape_variety.variety_id										
										LEFT OUTER JOIN inventory
										ON wine.wine_id = inventory.wine_id										
										LEFT OUTER JOIN items
										ON items.wine_id = wine.wine_id										
										LEFT OUTER JOIN customer
										ON customer.cust_id = items.cust_id
										
										WHERE wine_name LIKE '%".$wine_name."%'
										AND winery_name LIKE '%".$winery_name."%'
										AND region_name = '".$wine_region."'
										AND inventory.on_hand >= '".$wine_quantity."'
										AND wine.year >='".$wine_yearMin."'
										AND wine.year <='".$wine_yearMax."'
										AND inventory.cost >= '".$wine_costMin."'
										AND inventory.cost <= '".$wine_costMax."'
										
										GROUP BY wine.wine_name										
										HAVING COUNT(wine.wine_id) >= '".$wine_purchased."'
										"
									);
									
		

		if(!($result = mysql_query( $query, $connection)))
	showerror();
	
		//check result 
		if (mysql_num_rows($result)>0){
			echo "<pre>\n<table border='1' cellpadding='10' align='center'>";
	echo "<tr>
	
	<td>No</td>
	<td>Wine Name</td>
	<td>wine variety</td>
	<td>year</td>
	<td>Winery</td>
	<td>Region</td>
	<td>Cost</td>
	<td>Quantity on hand</td>
	<td>Number of customer purchased</td></tr>";
	$count = 0;
	
	while ($row = mysql_fetch_assoc($result)){	
	$count++;
	
						echo "<tr>
						<td>".$count."</td>
						<td>".$row['wine_name']."</td>
						<td>".$row['variety']."</td>
						<td>".$row['year']."</td>
						<td>".$row['winery_name']."</td>
						<td>".$row['region_name']."</td>
						<td>".$row['cost']."</td>
						<td>".$row['on_hand']."</td>
						<td>".$row['custNumber']."</td></tr>";
	
	
	}
	echo "   </table> </pre>";
		 }	
		 //no result notification
		else {
			echo "</br></br><center><b>No records match your search criteria.</b></br></br>Redirecting back to search page. </center>"; 
		
		header( "refresh:4;url=index.php" );}	
		
		}
		 
		 //price range error notification
			 else {
				 echo "</br></br><center>Your winery minimum price " .$wine_costMin. " is bigger than your maximum price " .$wine_costMax."</center>";
			 		echo "</br></br><center>Redirecting back to search page.</center>";
					 header( "refresh:4;url=index.php");}
					 
			 }
			 
		 
		//year range error notification
		else { echo "</br></br><center>Your winery year from" .$wine_yearMin. " is bigger than to " .$wine_yearMax." year</center>";
			 		echo "</br></br><center>Redirecting back to search page.</center>";
					 header( "refresh:4;url=index.php"); }
	
	
	
	}
	//number error notification
		else { echo"</br></br><center>Wine years, number of wines, number of customer purchased, and cost range must input Number only</br></br>Redirecting back to search page. </center>";
		
			header( "refresh:4;url=index.php" );
		}
mysql_close($connection);
	
?>
	
 </br></br><a href="index.php"><center><b>Search again </b></center></a>
	