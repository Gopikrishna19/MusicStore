<?php
    class Concert_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function getConcerts() {
            return $this->db->select("select * from concert");
        }

        public function getConcert($cid) {
            return $this->db->select("select * from concert join venue using(venueid)".
            " join user using(userid) join band using(bandid) where cid = :cid", [":cid" => $cid]);
        }

        public function getReviews($cid) {
            return $this->db->select("select * from review where cid = :cid", [":cid" => $cid]);
        }
    }
?>