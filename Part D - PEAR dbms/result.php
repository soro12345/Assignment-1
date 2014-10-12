<?php

/*SIR YOU HAVE TO CHANGE BACK THIS TO YOUR DRIVE!!!!!*/ /*READ THIS <<<<<<<<<<<<<<<<<<<<<<<<<<*/
	set_include_path('D:/wamp/wamp/bin/php/php5.4.12/pear');
	require_once "HTML/Template/IT.php";
	/*CHANGE BACK TO YOUR DRIVE SIR*/
	
	require_once "DB.php";
	$template = new HTML_Template_IT();
	$template->loadTemplatefile("result_template.tpl",true,true);
	$message = "No records match your search criteria";
	$message2 = "Your minimum price is bigger than your maximum price";
	$message3 = "Your start year is bigger than your end year";
	$message4 =  "Wine years, number of wines, number of customer purchased, and cost range must input Number only";
	
//START UP CONNECTION
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
									
		

		if(!($result = @$connection->query($query)))
	echo "query error";
	
		//check result 
		$rowsfound = $result->numRows();
		if ($rowsfound>0){
			
			//template!
			$template->setCurrentBlock("fieldName");
			$template->setVariable("No", "No");
			$template->setVariable("WineName", "Wine Name");
			$template->setVariable("WineVariety", "Wine Variety");
			$template->setVariable("Year", "Year");
			$template->setVariable("Winery", "Winery");
			$template->setVariable("Region", "Region");
			$template->setVariable("Cost", "Cost");
			$template->setVariable("Quantity", "Quantity on hand");
			$template->setVariable("Purchased", "Number of customer purchased");
			$template->parseCurrentBlock();
			
	$count = 0;
	
	while ($row = $result->fetchRow()){	
	$count++;
	
				//use of template
						$template->setCurrentBlock("result");
						$template->setVariable("No", $count);
						$template->setVariable("wineName", $row[1]);
						$template->setVariable("variety", $row[6]);
						$template->setVariable("year", $row[2]);
						$template->setVariable("wineryName", $row[3]);
						$template->setVariable("regionName", $row[4]);
						$template->setVariable("cost", $row[7]);
						$template->setVariable("onHand", $row[8]);
						$template->setVariable("custNumber", $row[9]);
						$template->parseCurrentBlock();
	
	
	}
	
		 }	
		 
		 //change to template
		else { //no result notification
		$template->setCurrentBlock("noResult");
		$template->setVariable("message", $message);
		$template->parseCurrentBlock();
		header( "refresh:4;url=index.php" );	}
		
		}
		
		 //price range error notification
			 else {
				 $template->setCurrentBlock("noResult");
		$template->setVariable("message", $message2);
		$template->parseCurrentBlock();
		header( "refresh:4;url=index.php" );
		}
					 
			 }
			 
		 
		//year range error notification
		else { $template->setCurrentBlock("noResult");
		$template->setVariable("message", $message3);
		$template->parseCurrentBlock();
		header( "refresh:4;url=index.php" ); }
	
	
	
	}
	//number error notification
		else { $template->setCurrentBlock("noResult");
		$template->setVariable("message", $message4);
		$template->parseCurrentBlock();
		header( "refresh:4;url=index.php" );
		}
		
		//show template
		$template->show();
		
		//close connection
$connection->disconnect();
	
?>
	
 </br></br><a href="index.php"><center><b>Search again </b></center></a>
	