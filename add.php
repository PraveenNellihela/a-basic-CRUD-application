<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['add'])){
    $year = isset($_POST["year"]) ? $_POST['year'] : '';
    $mileage = isset($_POST["mileage"]) ? $_POST['mileage'] : '';
    $make = isset($_POST["make"]) ? $_POST['make'] : '';
    $model = isset($_POST["model"]) ? $_POST['model'] : '';
    if ( !is_numeric($year) || !is_numeric($mileage) ) {
        $_SESSION['add_failure'] = "All values are required";
        header("Location: add.php");
        return;
    }else if (strlen($year) < 1 || (strlen($mileage) < 1  ) || (strlen($make) < 1  ) || (strlen($model) < 1  )  ) {
        $_SESSION['add_failure'] = "All fields are required";
        header("Location: add.php");
        return;
    }else{
        $stmt = $pdo->prepare('INSERT INTO autos
            (make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':mo' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );
        //echo ('<p style="color: green;">'.'Record inserted'."</p>\n");
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
    }
}



?>

<html>
<head>
<title>Praveen Nellihela Add Autos</title>
</head>
<body>
    <h1>Add autos</h1>

    <?php
    if ( isset($_SESSION['add_failure']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['add_failure'])."</p>\n");
        unset($_SESSION['add_failure']);
    }
    ?>

    <form method="POST">
    <p>
    <label for="make">Make</label>
    <input type="text" name="make" id="make">
    </p><p>
    <label for="model">Model</label>
    <input type="text" name="model" id="model">
    </p><p>
    <label for="year">Year</label>
    <input type="text" name="year" id="year">
    </p><p>
    <label for="mileage">Mileage</label>
    <input type="text" name="mileage" id="mileage">
    </p>
    <p>
    <input type="submit" value="Add" name="add" >
    <input type="submit" value="Cancel" name="cancel">
    </p>
    </form>



    </body>
</html>
