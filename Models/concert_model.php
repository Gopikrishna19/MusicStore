<?php
    class Concert_Model extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function getConcerts($cond, $filter, $genre) {
            $param = []; if($filter) $param[":subcatid"] = $genre;
            return $this->db->select("select cid, cname, ctime from concert ".$cond, $param);
        }

        public function getConcert($cid) {
            return $this->db->select("select * from concert join venue using(venueid)".
            " join user using(userid) join band using(bandid) where cid = :cid", [":cid" => $cid]);
        }

        public function getReviews($cid) {
            return $this->db->select("select * from review where cid = :cid", [":cid" => $cid]);
        }

        public function getConcertGenres($cid) {
            return $this->db->select("select * from concertgenre join subcategory using(subcatid) where cid = :cid", [":cid" => $cid]);
        }

        public function getGenreName($subcatid) {
            return $this->db->select("select subcatname from subcategory where subcatid = :subcatid", [":subcatid" => $subcatid]);
        }

        public function getAttend($cid) {
            return $this->db->select("select * from attend where cid = :cid and userid = :userid", [":cid" => $cid, ":userid" => User::id()]);
        }

        public function getUserLists() {
            return $this->db->select("select * from userlist where userid = :userid", [":userid" => User::id()]);
        }

        public function isConcertOwner($cid) {
            return $this->db->select("select * from concert where cid = :cid and userid = :userid", [":cid" => $cid, ":userid" => User::id()]);
        }

        public function isValidApprover($cid) {
            $approve = "(select userid1 from approve where cid = :cid and userid2 is NULL)";
            return $this->db->select("select userid from user ".
                                     "where (userid not in  $approve or $approve is NULL)".
                                     "and userid = :userid and rating >= 7",
                                     [":cid" => $cid, ":userid" => User::id()]);
        }

        public function setApprove($cid) {
            $sth = $this->db->prepare("update approve set ".
                                      "userid1 = case when userid1 is null then :userid else userid1 end, ".
                                      "userid2 = case when userid1 is not null and userid1 != :userid then :userid else userid2 end ".
                                      "where cid = :cid");
            $sth->bindValue(":cid", $cid);
            $sth->bindValue(":userid", User::id());

            $sth->execute();
        }

        public function setAttended($cid, $attended) {
            $this->db->update("attend", ["attended" => $attended], "cid = $cid and userid = ".User::id());
        }

        public function setConcert($data) {
            $this->db->update("concert", $data, "cid = ".$data["cid"]);
        }

        public function createRecommend($cid) {
            if($this->db->select("select * from recommend where cid = :cid and userid = :userid", [":cid" => $cid, ":userid" => User::id()]) == NULL)
                $this->db->insert("recommend", ["cid" => $cid, "userid" => User::id()]);
        }

        public function createReview($data) {
            $data["userid"] = User::id();
            $this->db->insert("review", $data);
        }

        public function createAttend($cid) {
            $this->db->insert("attend", ["cid" => $cid, "userid" => User::id()]);
        }

        public function deleteAttend($cid) {
            $this->db->delete("attend", "cid = $cid and userid = ".User::id());
        }

        public function deleteConcert($cid) {
            $this->db->delete("concert", "cid = $cid");
        }

        public function addToList($cid, $listid) {
            $exists = $this->db->select("select * from list where cid = :cid and listid = :listid", [":cid" => $cid, ":listid" => $listid]);
            if($exists == NULL) {
                $this->db->insert("list", ["cid" => $cid, "listid" => $listid]);
                return 1;
            } else {
                return 2;
            }
            return 0;
        }
    }
?>