<?php
require_once 'pdo.php';
session_start();
$salt = 'umsi@umich.edu';
$stored_hash = 'd54ab375af75d95dc943ffb991063e8f';
if(isset($_POST['email']) && isset($_POST['pass'])){
  if (strlen($_POST['email']) <1 || strlen($_POST['pass']) <1) {
    $_SESSION['error']='User name and password are required';
    header("Location: login.php");
    return;
  }
  else{
    $check = hash('md5', $salt.$_POST['pass']);
    if ( $check == $stored_hash ) {
        error_log("Login success ".$_POST['email']);
        $_SESSION['success'] ="Login successful";
        $_SESSION['name'] = $_POST['email'];
        header("Location: index.php");
        return;
    } else {
        error_log("Login fail ".$_POST['email']." $check");
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Page Praveen Nellihela</title>
  </head>
  <body>
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
    }
    ?>
    <form method="post">
      <label for="nam">User Name</label>
      <input type="text" name="email" id="nam"><br/>
      <label for="id_1723">Password</label>
      <input type="text" name="pass" id="id_1723"><br/>
      <p>
        <input type="submit" name="Login" value="Log In">
        <a href="index.php">Cancel</a>
      </p>

    </form>
  </body>
</html>
