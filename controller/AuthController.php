<?php

class AuthController {
    public function login() {
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password']
        ];

        $validation = new AuthValidation;
        $validation->setData($data);
        if($validation->validate() === false) {
            $params = sprintf("?email=%s", $_POST['email']);
            $error_msg = $validation->getErrorMessages();

            session_start();
            $_SESSION['error'] = $error_msg;

            header("Location: ./login.php" . $params);

            exit;

        }

        $validate_data = $validation->getData();
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $user = new User;
        $user->setEmail($email);
        $user->setPassword($password);
        $result = $user->getUserByEmail();

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
