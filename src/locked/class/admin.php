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

        function generate_secure_random_string($length)
        {
            $random_string = '';
            for($i = 0; $i < $length; $i++) {   
                $number = random_int(0, 36);
                $character = base_convert($number, 10, 36);
                $random_string .= $character;
            }
            return $random_string;
        }
        
        public function createSession($username)
        {
            $session_id = $this->generate_secure_random_string(18);
            $expires = date('c', time()+(15*60));

            $query = "INSERT INTO sessions (username, session, expires) VALUES (?,?,?)";
            $paramType = "sss";
            $paramArray = array(
                $username,
                $session_id,
                $expires,
            );
            $queryResult = $this->ds->insert($query, $paramType, $paramArray);
            return $session_id;
        }

        public function extendSession($username, $session_id)
        {
            $expires = date('c', time()+(15*60));

            $query = "UPDATE sessions SET expires = ? WHERE username = ? AND session = ?";
            $paramType = "sss";
            $paramArray = array(
                $expires,
                $username,
                $session_id,
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return $queryResult;
        }

        public function deleteSession($username, $session_id)
        {
            $query = "DELETE FROM sessions WHERE username = ? AND session = ?";
            $paramType = "ss";
            $paramArray = array(
                $username,
                $session_id,
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return $queryResult;
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
                    $_SESSION["session-id"] = $this->createSession($queryResult[0]["username"]);
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

        public function generateToken($username)
        {
            $token = $this->generate_secure_random_string(32);
            $tokenHash = password_hash($token, PASSWORD_DEFAULT);

            $query = "UPDATE logins SET token = ? WHERE username = ?";
            $paramType = "ss";
            $paramArray = array(
                $tokenHash,
                $username
            );

            $this->ds->execute($query, $paramType, $paramArray);
            return $token;
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
