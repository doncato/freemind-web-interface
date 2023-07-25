<?php
    namespace App;

    define("ADMIN", "doncato");

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

        function does_id_exist($id)
        {
            $query = "SELECT 1 FROM logins WHERE id = ?";
            $paramType = "i";
            $paramArray = array(
                $id
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return mysqli_num_rows($queryResult) > 0;
        }

        function does_username_exist($username)
        {
            $query = "SELECT 1 FROM logins WHERE username = ?";
            $paramType = "s";
            $paramArray = array(
                $username
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return mysqli_num_rows($queryResult) > 0;
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
        
        public function createSession($id)
        {
            $session_id = $this->generate_secure_random_string(18);
            $expires = date('c', time()+(15*60));

            $query = "INSERT INTO sessions (id, session, expires) VALUES (?,?,?)";
            $paramType = "sss";
            $paramArray = array(
                $id,
                $session_id,
                $expires,
            );
            $queryResult = $this->ds->insert($query, $paramType, $paramArray);
            return $session_id;
        }

        public function extendSession($id, $session_id)
        {
            $expires = date('c', time()+(15*60));

            $query = "UPDATE sessions SET expires = ? WHERE id = ? AND session = ?";
            $paramType = "sss";
            $paramArray = array(
                $expires,
                $id,
                $session_id,
            );
            $queryResult = $this->ds->execute($query, $paramType, $paramArray);
            return $queryResult;
        }

        public function deleteSession($id, $session_id)
        {
            $query = "DELETE FROM sessions WHERE id = ? AND session = ?";
            $paramType = "ss";
            $paramArray = array(
                $id,
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
                    $_SESSION["id"] = $queryResult[0]["id"];
                    $_SESSION["session-id"] = $this->createSession($queryResult[0]["id"]);
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
            $succ = false;
            //$id = random_int(1, 2147483646);
            $id = 0;
            for ($i = 0; $i < 1000; $i++) {
                if (!$this->does_id_exist($id)) {
                    $succ = true;
                    break;
                } else {
                    $id = random_int(1, 2147483646);
                }
            }
            if ($this->does_username_exist($username)) {
                $succ = false;
            }
            if (!$succ) {
                return false;
            }
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO logins (username, password, token, id) VALUES (?, ?, ?, ?)";
            $paramType = "sssi";
            $paramArray = array(
                $username,
                $passwordHash,
                password_hash($this->generate_secure_random_string(32), PASSWORD_DEFAULT),
                $id
            );
            $queryResult = $this->ds->insert($query, $paramType, $paramArray);
            return $queryResult == 0;
        }

        public function removeLogin($username)
        {
            $query = "DELETE FROM logins WHERE username = ?";
            $paramType = "s";
            $paramArray = array(
                $username
            );
            $queryResult = $this->ds->insert($query, $paramType, $paramArray);
            return $queryResult == 0;
        }
    }
