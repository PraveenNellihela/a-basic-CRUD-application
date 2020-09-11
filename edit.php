
 <?php
 require_once "pdo.php";
 session_start();

 if ( ! isset($_SESSION['name']) ) {
     die('Not logged in');
 }
 if ( isset($_POST['year']) && isset($_POST['mileage'])
      && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['autos_id'])) {

     // Data validation
     if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
         $_SESSION['error'] = "Mileage and year must be numeric";
         header("Location: edit.php?autos_id=".$_POST['autos_id']);
         return;
     }else if (strlen($_POST['year']) < 1 || (strlen($_POST['mileage']) < 1  )
     || (strlen($_POST['make']) < 1  ) || (strlen($_POST['model']) < 1  )  ) {
         $_SESSION['error'] = "All fields are required";
         header("Location: edit.php?autos_id=".$_POST['autos_id']);
         return;
     }

     $sql = "UPDATE autos SET make = :make,
             model = :model, year = :year, mileage = :mileage
             WHERE autos_id = :autos_id";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(array(
         ':make' => $_POST['make'],
         ':model' => $_POST['model'],
         ':year' => $_POST['year'],
         ':mileage' => $_POST['mileage'],
         ':autos_id' => $_POST['autos_id']));
     $_SESSION['success'] = 'Record edited';
     header( 'Location: index.php' ) ;
     return;
 }


 $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
 $stmt->execute(array(":xyz" => $_GET['autos_id']));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

 if ( $row === false ) {
     $_SESSION['error'] = 'Bad value for autos_id';
     header( 'Location: index.php' ) ;
     return;
 }

 // Flash pattern
 if ( isset($_SESSION['error']) ) {
     echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
     unset($_SESSION['error']);
 }

 $ma = htmlentities($row['make']);
 $mo = htmlentities($row['model']);
 $ye = htmlentities($row['year']);
 $mi = htmlentities($row['mileage']);
 $autos_id = $row['autos_id'];
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Praveen Nellihela</title>
  </head>
  <body>

    <p>Edit Auto</p>
    <form method="post">
    <p>Make:
    <input type="text" name="make" value="<?= $ma ?>"></p>
    <p>Model:
    <input type="text" name="model" value="<?= $mo ?>"></p>
    <p>Year:
    <input type="text" name="year" value="<?= $ye ?>"></p>
    <p>Mileage:
    <input type="text" name="mileage" value="<?= $mi ?>"></p>
    <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
    <p><input type="submit" value="Save" name="update"/>
    <a href="index.php">Cancel</a></p>
    </form>


  </body>
</html>
