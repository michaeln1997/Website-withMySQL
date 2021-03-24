<!-- 
 Michael Nunes 				Principles of Database System 
 Dr. Stephen Blythe        30500-21
 Project #3				
 listRecipe.php
-->

<!--this php file is listing the ingredients and quantity from Recipe table where the recipe name is equal to the user input. And there listing in a table with a border of 4. Also, there is an option to go back to the main menu -->

<!--header of the page-->
<h1> List of ingredients and quantity </h1>
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

// find all matching recipename data
$queryString = "select Ingredient, Quantity from RecipeTable ".
               " where RecipeName =\"$recipe\"";

$status = mysqli_query($conn, $queryString);

if (!$status)
    die("Error running query: " . mysqli_error($conn));

//creating a table with a border of 4 with two column one of them for ingredients and another one for quantities

echo "<table border=4>";
echo "<tr> <th> Ingredients </th> <th> Quantities </th> </tr>";

while($row = mysqli_fetch_assoc($status))
    {
        echo "<tr> <td>".$row["Ingredient"]."</td>".  
                  "<td>".$row["Quantity"]."</td> </tr>";
    }

echo "</table>";

// close the connection (to be safe)
mysqli_close($conn);

//link to go back to the main menu 
echo "<a href=MainMenu.html>Go back to the main menu</a>";
?>
