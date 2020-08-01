<?php
//ini_set("display_errors", 1);
//error_reporting(E_ALL);

require_once '../../config/database.php';
require_once '../../model/Auth.php';
require_once '../../controller/AuthController.php';
require_once '../../validation/AuthValidation.php';

session_start();
$error = $_SESSION['error'];
unset($_SESSION["error"]);

if($_POST) {
  $action = new AuthController;
  $action->register();
}

$name = '';
$email = '';

if($_GET) {
  if(isset($_GET['name'])) {
    $name = $_GET['name'];
  }

  if(isset($_GET['email'])) {
    $email = $_GET['email'];
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <div class="userResister_wrapper">
      <h1>Register</h1>
      <form action="" method="post">
        <h2>ユーザー名</h2>
        <div class="error">
          <?php
            if(!empty($error['name'])) echo $error['name'];
          ?>
        </div>
        <input type="text" name="name" value="<?php echo $name;?>">

        <h2>メールアドレス</h2>
        <div class="error">
          <?php
            if(!empty($error['email'])) echo $error['email'];
          ?>
        </div>
        <input type="email" name="email" value="<?php echo $email;?>">

        <h2>パスワード</h2>
        <div class="error">
          <?php
            if(!empty($error['password'])) echo $error['password'];
          ?>
        </div>
        <input type="password" name="password">

        <h2>パスワード(確認用)</h2>
        <div class="error">
          <?php
            if(!empty($error['password_re'])) echo $error['password_re'];
          ?>
        </div>
        <input type="password" name="password_re">
        <input type="submit" class="btn" value="登録する">
      </form>
    </div>
  </body>
</html>