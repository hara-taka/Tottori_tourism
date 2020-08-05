<?php

class Auth {
    private $name;
    private $email;
    private $password;
    public $pdo;

    public function __construct() {
        $this->dbConnect();
    }

    public function dbConnect() {
        $this->pdo = new PDO(DSN, USERNAME, PASSWORD, OPTIONS);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function register() {

        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('INSERT INTO users (name,email,password,created_at,updated_at)
                                        VALUES(:name,:email,:password,:created_at,:updated_at)');
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $result = $stmt->execute();

            $this->pdo->commit();

            return $result;

        } catch (PDOException $e) {

            $this->pdo->rollBack();

            error_log($e->getMessage());
            return false;
        }
    }

  public function getUserByEmail() {
      try {
          $this->pdo->beginTransaction();

          $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
          $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          $this->pdo->commit();

          return $result;

      } catch (Exception $e) {

          $this->pdo->rollBack();

          error_log($e->getMessage());
          return false;

      }
  }

}