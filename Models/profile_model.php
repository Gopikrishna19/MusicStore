<?php
    class Profile_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function readPosts($username) {            
            return $this->db->select("select * from post where userid = :userid order by postdate desc",[":userid" => User::toId($username)]);
        }

        public function createPost($userid, $text, $visi) {
            return $this->db->insert("post", ["userid"=>$userid, "text"=>$text, "access"=>$visi]);
        }
    }
?>