<?php 
 	function Connect()
 	{	
 		$server = "localhost"; 
 		$userID = "";
 		$username = "root";  
 		$password = "";  
 		$db = "chatapp";    

		$connection = new mysqli($server, $username, $password, $db); 
   
     	if($connection->connect_error)
     	{
       		die("Error ".$connection->connect_errno."!: , ".$connection->connect_error);  
     	}

     	return $connection;
	}
?>
