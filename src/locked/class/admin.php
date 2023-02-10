<?php
    namespace App;

    use App\DataSource;

    class Admin
    {
        private $dbConn;

        private $ds;

        function __construct()
        {
            require_once "data.php";
            $this->ds = new DataSource();
        }

        public function checkLogin($username, $password)
        {
            $query = "SELECT * FROM logins WHERE username = ?";
            $paramType = "s";
            $paramArray = array(
                $username,
            );
            $queryResult = $this->ds->select($query, $paramType, $paramArray);
            if (! empty($queryResult)) {
                if (password_verify($password, $queryResult[0]["password"])) {
                    return true;
                }
            }
            return false;
        }

        public function processLogin($username, $password)
        {
            $query = "SELECT * FROM logins WHERE username = ?";
            $paramType = "s";
            $paramArray = array(
                $username,
            );
            $queryResult = $this->ds->select($query, $paramType, $paramArray);
            if (! empty($queryResult)) {
                if (password_verify($password, $queryResult[0]["password"])) {
                    $_SESSION["login"] = $queryResult[0]["username"];
                    return true;
                }
            }
        }

        public function changePassword($username, $old_password, $new_password)
        {
            $query = "SELECT * FROM logins WHERE username = ?";
            $paramType = "s";
            $paramArray = array(
                $username,
            );
            $queryResult = $this->ds->select($query, $paramType, $paramArray);
            if (! empty($queryResult)) {
                if (password_verify($old_password, $queryResult[0]["password"])) {
                    $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
                    $query = "UPDATE logins SET password = ? WHERE username = ?";
                    $paramType = "ss";
                    $paramArray = array(
                        $passwordHash,
                        $username,
                    );
                    $this->ds->execute($query, $paramType, $paramArray);
                    return $this->checkLogin($username, $new_password);
                }
            }
        }

        public function addLogin($username, $password)
        {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO logins (username, password) VALUES (?, ?)";
            $paramType = "ss";
            $paramArray = array(
                $username,
                $passwordHash
            );
            $queryResult = $this->ds->insert($query, $paramType, $paramArray);
            return $queryResult;
        }

        public function removeLogin($username, $password)
        {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "DELETE FROM logins WHERE username = ? AND password = ?";
            $paramType = "ss";
            $paramArray = array(
                $username,
                $passwordHash
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return $queryResult;
        }
    }
