<?php
		
    // Show error function    
   function showerror()
   {
      die("Error " . mysql_errno() . " : " . mysql_error());
   }
	
   // (1) Open the database connection
   if (!($connection = @ mysql_connect("localhost","root","")))
      die("Could not connect");

   // (2) Select the winestore database
   if (!mysql_select_db("winestore", $connection))
      showerror();
?>