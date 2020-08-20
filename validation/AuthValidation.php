<?php

class AuthValidation {
    private $data;
    private $error = [];

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function getErrorMessages() {
        return $this->error;
    }

    public function validate() {
        $email = $this->data['email'];
        $password = $this->data['password'];

        //未入力チェック(メールアドレス)
        if(empty($email)) {
            $this->error['email'] = '入力必須です';
        }

        //未入力チェック(パスワード)
        if(empty($password)) {
            $this->error['password'] = '入力必須です';
        }


        if(count($this->error) === 0) {
            //email形式チェック
            if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
                $this->error['email'] = 'Emailの形式で入力してください';
            }
        }

        if(count($this->error) > 0) {
            return false;
        }

        return true;
      }
}