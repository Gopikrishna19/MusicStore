<?php
    class User {
        public static function toName($id) {
            $db = new Database();
            $result = $db->select("select username from user where userid = :uid", [":uid" => $id]);
            return $result[0]["username"];
        }

        public static function toId($name) {
            $db = new Database();
            $result = $db->select("select userid from user where username = :uname", [":uname" => $name]);
            return $result[0]["userid"];            
        }

        public static function id() {
            return Session::get("userid");
        }

        public static function name() {
            return Session::get("username");
        }
    }
?>