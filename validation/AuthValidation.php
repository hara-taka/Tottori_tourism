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

    public function registerCheck() {
        $name = $this->data['name'];
        $email = $this->data['email'];
        $password = $this->data['password'];
        $password_re = $this->data['password_re'];

        //未入力チェック(ユーザー名)
        if(empty($name)) {
            $this->error['name'] = '入力必須です';
        }

        //未入力チェック(メールアドレス)
        if(empty($email)) {
            $this->error['email'] = '入力必須です';
        }

        //未入力チェック(パスワード)
        if(empty($password)) {
            $this->error['password'] = '入力必須です';
        }

        //未入力チェック(パスワード(確認用))
        if(empty($password_re)) {
            $this->error['password_re'] = '入力必須です';
        }

        if(count($this->error) === 0) {
            //最小文字数チェック(パスワード)
            $minLenPass = 6;
            if(mb_strlen($password) < $minLenPass) {
                $this->error['password'] = '6文字以上でご入力してください';
            }

            //最大文字数チェック(ユーザー名)
            $maxLenName = 20;
            if(mb_strlen($name) > $maxLenName){
                $this->error['name'] = '20文字以内でご入力してください';
            }

            //最大文字数チェック(メールアドレス)
            $maxLenEmail = 255;
            if(mb_strlen($email) > $maxLenEmail){
                $this->error['email'] = '255文字以内でご入力してください';
            }

            //最大文字数チェック(パスワード)
            $maxLenPass = 255;
            if(mb_strlen($password) > $maxLenPass){
                $this->error['password'] = '255文字以内でご入力してください';
            }

            //パスワード同一チェック
            if($password !== $password_re){
                $this->error['password_re'] = '「パスワード」「パスワード(確認用)」が不一致です';
            }

            if(count($this->error) === 0) {
                //email形式チェック
                if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
                    $this->error['email'] = 'Emailの形式で入力してください';
                }

                //email重複チェック
                try {
                    $pdo = new PDO(DSN, USERNAME, PASSWORD, OPTIONS);

                    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
                    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($result){
                        $this->error['email'] = 'このメールアドレスは既に登録されています';
                    }

                } catch (Exception $e) {

                    exit($e->getMessage());

                }

            }

        }

        if(count($this->error) > 0) {
            return false;
        }

        return true;

    }
}