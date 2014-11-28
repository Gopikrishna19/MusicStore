<?php
    class Profile_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function readPosts($username, $access) {            
            return $this->db->select("select * from post where userid = :userid and access >= :access order by postdate desc",
                                     [":userid" => User::toId($username), ":access" => $access]);
        }

        public function createPost($userid, $text, $visi) {
            return $this->db->insert("post", ["userid"=>$userid, "text"=>$text, "access"=>$visi]);
        }

        public function readReviews($username) {
            return $this->db->select("select * from review join concert using(cid) where review.userid = :userid order by reviewdate desc",
            [":userid" => User::toId($username)]);
        }

        public function readBy($username) {
            return $this->db->select("select * from concert where userid = :userid order by ctime", [":userid" => User::toId($username)]);
        }

        public function readAttending($username) {
            return $this->db->select("select * from attend join concert using(cid) where attend.userid = :userid and attended = 0 order by ctime", 
            [":userid" => User::toId($username)]);
        }

        public function readAttended($username) {
            return $this->db->select("select * from attend join concert using(cid) where attend.userid = :userid and attended = 1 order by ctime", 
            [":userid" => User::toId($username)]);
        }

        public function readArtist($username) {
            return $this->db->select("select * from band");
        }

        public function readFan($username) {
            return $this->db->select("select * from fan join band using(bandid) where userid = :userid", [":userid" => User::toId($username)]);
        }
    }
?>