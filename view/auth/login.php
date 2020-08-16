<?php
//ini_set("display_errors", 1);
//error_reporting(E_ALL);

require_once '../../config/database.php';
require_once '../../model/User.php';
require_once '../../controller/AuthController.php';
require_once '../../validation/AuthValidation.php';

session_start();
$error = $_SESSION['error'];
unset($_SESSION["error"]);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = new AuthController;
    $action->login();
}

$name = '';
$email = '';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['email'])) {
        $email = $_GET['email'];
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ログイン</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="login_wrapper">
            <h1>Login</h1>
            <form action="" method="post">
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
                <input type="submit" class="btn" value="ログイン">
            </form>
        </div>
    </body>
</html>