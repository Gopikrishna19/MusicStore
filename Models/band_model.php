<?php
    class Band_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function getBands($cond, $filter, $genre) {
            $param = []; if($filter) $param[":catid"] = $genre;
            return $this->db->select("select * from band ".$cond, $param);
        }

        public function getBand($bandid) {
            return $this->db->select("select * from band join category using(catid) where bandid = :bandid", [":bandid" => $bandid]);
        }        

        public function getConcerts($bandid, $cond = "") {
            return $this->db->select("select * from concert where bandid = :bandid ".$cond, [":bandid" => $bandid]);
        }

        public function getArtists($bandid) {
            return $this->db->select("select * from artist join user using(userid) where bandid = :bandid", [":bandid" => $bandid]);
        }

        public function getGenreName($catid) {
            return $this->db->select("select catname from category where catid = :catid", [":catid" => $catid]);
        }

        public function countFans($bandid) {
            return $this->db->select("select count(*) as n from fan where bandid = :bandid", [":bandid" => $bandid]);
        }

        public function isFan($bandid) {
            return $this->db->select("select * from fan where userid = :userid and bandid = :bandid",
                                      [":bandid" => $bandid, ":userid" => User::id()]);
        }

        public function createFan($bandid) {
            $this->db->insert("fan", ["userid" => User::id(), "bandid" => $bandid]);
        }

        public function deleteFan($bandid) {
            $this->db->delete("fan", "userid = ".User::id()." and bandid = $bandid");
        }
    }
?>