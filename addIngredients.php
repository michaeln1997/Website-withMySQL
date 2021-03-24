<!-- 
 Michael Nunes 				Principles of Database System 
 Dr. Stephen Blythe        30500-21
 Project #3				
 addIngredients.php
-->

<!--this php file is adding ingredients to the table and updates when ingredients are the same. Also, there is an option 
to go back to the main menu -->


<?php

// to get data stored in a session, you must let the browser know to start a session
session_start();
// take data values from the session variables and store them
$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["pass"];
$dbName = $user;


// build the connection ...
$conn = mysqli_connect($host, $user, $pass, $dbName);


// Get data from user
$ingredients = $_POST["ingredient"];
$quantities = $_POST["quantity"];

// find all matching ingredient data
$queryString = "select Ingredient, Quantity from Inventory ".
               " where Ingredient =\"$ingredients\"";
              
$status = mysqli_query($conn, $queryString);

// try and insert request
$queryString = "INSERT INTO Inventory VALUES (\"$ingredients\", $quantities)";
$status = mysqli_query($conn, $queryString);

if (!$status)
{
 //update the inventory table and set the quantity to quantity plus the new quantities where ingredients mach
 $queryString = " update Inventory set Quantity = Quantity+ $quantities where Ingredient =\"$ingredients\"";
 $status = mysqli_query($conn, $queryString);
}      
        
// close the connection (to be safe)
mysqli_close($conn);

// link to go back to the main menu
echo "<a href=MainMenu.html>Go back to the main menu</a>";
?>
