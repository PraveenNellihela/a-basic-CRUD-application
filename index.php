<?php
require_once 'pdo.php';
session_start();

$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Praveen Nellihela Start Page</title>
 </head>
 <body>
   <h3>Welcome to the Automobiles Database</h3>
   <?php
   if ( isset($_SESSION['error']) ) {
       echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
       unset($_SESSION['error']);
   }
   if ( isset($_SESSION['success']) ) {
       echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
       unset($_SESSION['success']);
   }
   if (isset($_SESSION['name'])) {
     if ($rows == false) {
       echo("No rows found");
     }
     else {
       echo('<table border="1">'."\n");
       $stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
       while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
           echo "<tr><td>";
           echo(htmlentities($row['make']));
           echo("</td><td>");
           echo(htmlentities($row['model']));
           echo("</td><td>");
           echo(htmlentities($row['year']));
           echo("</td><td>");
           echo(htmlentities($row['mileage']));
           echo("</td><td>");
           echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
           echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
           echo("</td></tr>\n");
       }
     }
     echo('</table><p><a href="add.php">Add New Entry</a>'."</p>");
     echo('<a href="logout.php">'.'Logout'."</a>");
   }


   if (! isset($_SESSION['name']) ) {
      echo('<a href="login.php">'.'Please log in'."</a>");
    }
   ?>
 </body>
</html>
