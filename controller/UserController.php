<?php

class UserController {
    public function create() {
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
            "password_re" => $_POST['password_re']
        ];

        $validation = new UserValidation;
        $validation->setData($data);
        if($validation->validate() === false) {
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

        $user = new User;
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $result = $user->create();

        if($result === false) {
            $params = sprintf("?name=%s&email=%s", $name, $email);
            header("Location: ./register.php" . $params);
        }

        header("Location: register.php");
    }

}
