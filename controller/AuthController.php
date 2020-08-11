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

}
