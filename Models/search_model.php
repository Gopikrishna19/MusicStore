<?php
    class Search_Model extends Model {
        public function __construct() {
            parent::__construct();
        }
    
        public function searchPeople($key) {
            return $this->db->select("select * from user where username like :key or fname like :key or lname like :key", [":key" => "%$key%"]);
        }
    
        public function searchBands($key, $genre) {
            $where = " where 1";
            $param = [];
            if($key != "") {
                $where .= " and bname like :key";
                $param[":key"] = "%$key%";
            }
    
            if($genre != "") {
                $where .= " and catid = :genre";
                $param[":genre"] = $genre;
            }            
            return $this->db->select("select * from band ".$where, $param);
        }
    
        public function searchConcerts($key, $date, $creator, $genre) {
            $where = " where 1";
            $param = [];
            if($key != "") {
                $where .= " and cname like :key";
                $param[":key"] = "%$key%";
            }

            if($creator != "") {
                $where .= " and (username like :creator or fname like :creator or lname like :creator)";
                $param[":creator"] = "%$creator%";
            }
    
            if($genre != "") {
                $where .= " and catid = :genre";
                $param[":genre"] = $genre;
            }

            if($date != "") {
                $where .= " and date(ctime) = date(:date)";
                $param[":date"] = $date;
            }
            echo $where;
            return $this->db->select("select * from concert join user using(userid) left outer join concertgenre using(cid) ".
                                     "left outer join subcategory using(subcatid) ".$where." group by cid", $param);
        }

        public function recommendConcerts() {
            return $this->db->select("select * from usergenre u join concertgenre using(subcatid) ".
                                     "join concert using(cid) where u.userid = :userid and ctime > CURRENT_TIMESTAMP group by cid limit 10",
                                     [":userid" => User::id()]);
        }

        public function recommendBands() {
            return $this->db->select("select * from band join category using(catid) join subcategory using(catid) ".
                                     "join usergenre using(subcatid) join user using(userid) ".
                                     "where userid = :userid group by bandid limit 10", [":userid" => User::id()]);
        }

        public function recommendPeople() {
            return $this->db->select("select u1.* from user u1 join usergenre ug on u1.userid = ug.userid ".
                                     "join user u2 on u2.userid = ug.userid where u2.userid != :userid group by u1.userid limit 10",
                                     [":userid" => User::id()]);
        }
    }
?>