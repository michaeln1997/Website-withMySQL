<!-- 
 Michael Nunes 				Principles of Database System 
 Dr. Stephen Blythe        30500-21
 Project #3				
 createRecipe.php
-->

<!--this php file is inserting a recipe with the recipe name, ingredients and quantities to the table.  and updates when ingredients are the same. Also, there is an option to go back to the main menu -->

<?php

// to get data stored in a session, you must let the browser know to start a session
session_start();

// take data values from the session variables and store them
$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["pass"];

//remember, for our purposes the DB is the same as the username ...
$dbName = $user;



// build the connection ...
$conn = mysqli_connect($host, $user, $pass, $dbName);

// Get data from user
$recipe = $_POST["recipe"];
$ingredient = $_POST["ingredient"];
$quantitys = $_POST["quantity"];

// try and insert request
$queryString = "insert into RecipeTable".
           " values (\"$recipe\", \"$ingredient\", $quantitys)";
$status = mysqli_query($conn, $queryString);

if (!$status)
        die("Error performing insertion: " . mysqli_error($conn));
        
// close the connection (to be safe)
mysqli_close($conn);

//link to go back to the main menu
echo "<a href=MainMenu.html>Back to the main menu</a>";
?>
