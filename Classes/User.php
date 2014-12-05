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

            if($result == NULL) {
                $error = new Error(410);
                $error->index();
                die;
            }

            return $result[0]["userid"];            
        }

        public static function id() {
            return Session::get("userid");
        }

        public static function name() {
            return Session::get("username");
        }

        public static function isOwner($username) {
            return self::name() == $username;
        }

        public static function isFollower($username) {
            $db = new Database();
            return $db->select("select username from user join follow using(userid) ".
                                "where followerid = :followerid and username = :uname",
                                [":followerid" => User::id() ,":uname"=>$username]) != NULL;
        }
    }
?>