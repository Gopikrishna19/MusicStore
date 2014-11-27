<?php
    class Home_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function checkUserExists($username, $password = NULL) {
            if($password !== NULL) {
                $password = Hash::digest($password);
                $result = $this->db->select("select userid, username from user where username like :user and password = :pass", 
                                            [":user" => $username, ":pass" => $password]);
                if($result != NULL) {
                    Session::set("username", $result[0]["username"]);
                    Session::set("userid", $result[0]["userid"]);
                    return 'true';
                } else {
                    return 'false';
                }
            } else {
                return $this->db->select("select username from user where username like :user", 
                                            [":user" => $username]) != NULL ? 'true' : 'false';
            }
        }

        public function createUser($username, $password) {
            $password = Hash::digest($password);
            $this->db->insert("user",["username" => $username,"password" => $password]);
        }
    }
?>