<!-- 
 Michael Nunes        Principles of Database System 
 Dr. Stephen Blythe        30500-21
 Project #3       
 loginpage.php
-->

<!--this php file is creating the tables for inventory and the recipe table. Also, there is an option to go to the main menu -->

<?php

// to get data stored in a session, you must let the browser know to start a session
session_start();

// then take data values and store them into a session variable ...
$_SESSION["host"] = $_POST["host"];
$_SESSION["user"] = $_POST["user"];
$_SESSION["pass"] = $_POST["password"];

// take data values and store them into host, user and pass
$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["pass"];

//remember, for our purposes the DB is the same as the username ...
$dbName = $user;


// build the connection ...
echo "Attempting to connect to DB server: $host ...";
$conn = mysqli_connect($host, $user, $pass, $dbName);
if (!$conn)
	// die is a php function that terminates execution. 
	//   the . means string concatenation in php. 
	die("Could not connect:".mysqli_connect_error());
else
	echo " connected!<br>";

// try and create the table (if it does not exist) for Recipe
$queryString = "create table if not exists RecipeTable".
               " (RecipeName char(50), Ingredient char(50), Quantity integer,".
               " PRIMARY KEY (RecipeName, Ingredient) )";
$status = mysqli_query($conn, $queryString);
if (!$status)
    die("Error creating table: " . mysqli_error($conn));
    
// try and create the table (if it does not exist) for Inventory
$queryString = "create table if not exists Inventory".
               " (Ingredient char(50), Quantity integer,".
               " PRIMARY KEY (Ingredient) )";
               
$status = mysqli_query($conn, $queryString);
if (!$status)
    die("Error creating table: " . mysqli_error($conn));

// close the connection (to be safe)
mysqli_close($conn);
// link to go the main menu
echo "<a href=MainMenu.html>Go to the main menu</a>";
?>

