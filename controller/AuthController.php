<?php

class AuthController {
    public function register() {
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
            "password_re" => $_POST['password_re']
        ];

        $validation = new AuthValidation;
        $validation->setData($data);
        if($validation->registerCheck() === false) {
            $params = sprintf("?name=%s&email=%s", $_POST['name'], $_POST['email']);
            $error_msg = $validation->getErrorMessages();

            session_start();
            $_SESSION['error'] = $error_msg;

            header("Location: ./register.php" . $params);

            exit;
        }

        $validate_data = $validation->getData();
        $name = $validate_data['name'];
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $auth = new Auth;
        $auth->setName($name);
        $auth->setEmail($email);
        $auth->setPassword($password);
        $result = $auth->register();

        if($result === false) {
            $params = sprintf("?name=%s&email=%s", $name, $email);
            header("Location: ./register.php" . $params);
        }

        header("Location: register.php");
    }

    public function login() {
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password']
        ];

        $validation = new AuthValidation;
        $validation->setData($data);
        if($validation->loginCheck() === false) {
            $params = sprintf("?email=%s", $_POST['email']);
            $error_msg = $validation->getErrorMessages();

            session_start();
            $_SESSION['error'] = $error_msg;

            header("Location: ./login.php" . $params);

        }

        $validate_data = $validation->getData();
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $auth = new Auth;
        $auth->setEmail($email);
        $auth->setPassword($password);
        $result = $auth->login();

        if($result){
            $pass_result = password_verify($password, $result['password']);
        }

        if($pass_result === false) {

            $_SESSION['error']['email'] = 'メールアドレスもしくはパスワードが異なります';
            $params = sprintf("?email=%s", $email);
            header("Location: ./login.php" . $params);

        }elseif($pass_result === true){

            //ユーザーIDを格納
            $_SESSION['user_id'] = $result['id'];

            header("Location: ../picture/index.php");

        }

    }

}
