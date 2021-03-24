<!-- 
 Michael Nunes        Principles of Database System 
 Dr. Stephen Blythe        30500-21
 Project #3       
 buyIngredients.php
-->

<!--this php file is buying the ingredients and quantity to make the recipe of whatever food. if there is not enought inventory, do not do anything. Otherwise, do the recipe. Also, there is an option to go back to the main menu -->

<!--header of the page-->
<h1> Buy all recipe ingredients from the store </h1>
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

if(!$conn)
 //terminates the execution if there is an error with the connection.
 die(mysqli_connect_error());


// Get data from user
$recipe = $_POST["recipe"];  
// Start transaction
$queryString = " start transaction ";
$status = mysqli_query($conn, $queryString);

// select ingredient and quantity where recipeName and recipe match
$queryString = "select Ingredient, Quantity from RecipeTable ".
               " where RecipeName =\"$recipe\"";

$status = mysqli_query($conn, $queryString);

if (!$status)
    die("Error running query: " . mysqli_error($conn));
$valuex = true; // a boolean to make control


while($row = mysqli_fetch_assoc($status))
    {
        $Ingredient = $row["Ingredient"];  
        $quantities = $row["Quantity"];
        // gets the quantity of ingredient in invetory
        $queryString = "select Quantity from Inventory ".
        " where Ingredient = \"$Ingredient\"";

        $sta =  mysqli_query($conn, $queryString);

        if (!$sta){
          die("Error running query: " . mysqli_error($conn));
        $valuex = false; // the ingredient does not exist
      }

      
       $r = mysqli_fetch_assoc($sta);
      
       $newq = $r["Quantity"] - $quantities;
       //update the quantity 
       if ($quantities > $r["Quantity"]){
        echo " <br> There are not enough $Ingredient in the Inventory.";
          $valuex = false; // make the valuex to false since there are not enought ingredients
       }else {
        // it is getting the quantity need it to buy the ingredients and update.
        $queryString = " UPDATE Inventory set Quantity = \"$newq\" WHERE Ingredient = \"$Ingredient\" ";
          
      $sta = mysqli_query($conn, $queryString);
    }
}

if ($valuex == false)
{
  $queryString = " rollback ";
        // The Transaction failed, so do not commit
  $status = mysqli_query($conn, $queryString);
  echo "<br> Sorry, we cannot make the sale";
  echo "<br>";
}
else
{
  $queryString = " commit "; // commit the transaction 
  $status = mysqli_query($conn, $queryString);
  echo " <br> The inventory has been updated, congratulations";
}


// close the connection (to be safe)
mysqli_close($conn);

//link to go back to the main menu 
echo "<a href=MainMenu.html>Go back to the main menu</a>";
?>
