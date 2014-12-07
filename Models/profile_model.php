<?php
    class Profile_Model extends Model {
        public function __construct() {
            parent::__construct();
        }
    
        public function readUser($userid) {
            return $this->db->select("select * from user where userid = :userid", [":userid" => $userid]);
        }
    
        public function readUserGenre($userid) {
            return $this->db->select("select subcatid, subcatname from usergenre join subcategory using(subcatid) where userid = :userid",
            [":userid" => $userid]);
        }
    
        public function readPosts($username, $access) {            
            return $this->db->select("select * from post where userid = :userid and access >= :access order by postdate desc",
                                     [":userid" => User::toId($username), ":access" => $access]);
        }
    
        public function readReviews($username) {
            return $this->db->select("select * from review join concert using(cid) where review.userid = :userid order by reviewdate desc",
            [":userid" => User::toId($username)]);
        }
    
        public function readBy($username) {
            return $this->db->select("select * from concert where userid = :userid order by ctime", [":userid" => User::toId($username)]);
        }
    
        public function readAttend($username, $attend = 0) {
            return $this->db->select("select * from attend join concert using(cid) where attend.userid = :userid and attended = :attend order by ctime", 
            [":userid" => User::toId($username), ":attend" => $attend]);
        }
    
        public function readArtist($username) {
            return $this->db->select("select * from band join artist using(bandid) where userid = :userid", [":userid" => User::toId($username)]);
        }
    
        public function readFan($username) {
            return $this->db->select("select * from fan join band using(bandid) where userid = :userid", [":userid" => User::toId($username)]);
        }
    
        public function readFollow($username, $follower = FALSE, $mutual = FALSE) {
            $using = $follower ? "followerid" : "userid";
            $fcol = $follower ? "userid" : "followerid";
            if(!$mutual) {
                return $this->db->select("select * from follow f join user u on f.$using = u.userid where f.$fcol = :userid",
                [":userid" => User::toId($username)]);
            } else {
                return $this->db->select(
                "select * from follow f join user u on f.$using = u.userid where ".
                "f.$using in (select $using from follow where $fcol = :home) and ".
                "f.$using in (select $using from follow where $fcol = :guest) group by f.$using",
                [":home" => User::id(),":guest" => User::toId($username)]);
            }
        }

        public function readLists($username) {
            return $this->db->select("select * from userlist where userid = :userid", [":userid" => User::toId($username)]);
        }

        public function readListName($listid) {
            return $this->db->select("select listname from userlist where listid = :listid", [":listid" => $listid]);
        }

        public function readListConcerts($listid) {
            return $this->db->select("select * from list join concert using(cid) where listid = :listid", [":listid" => $listid]);
        }

        public function readNewConcerts() {
            return $this->db->select("select type, cid, cname, username, fname, created as stamp ".
                                     "from concert join user using(userid) join follow f using(userid) join (select 'concert' as type) z ".
                                     "where created >= (now() - interval 1 day) and f.followerid = :followerid", [":followerid" => User::id()]);
        }

        public function readNewRecommends() {
            return $this->db->select("select type, cid, cname, username, fname, recdate as stamp ".
                                     "from recommend r join user u on u.userid = r.userid ".
                                     "join follow f on u.userid = f.userid ".
                                     "join concert using(cid) join (select 'recommend' as type) z ".
                                     "where recdate >= (now() - interval 1 day) and f.followerid = :followerid", [":followerid" => User::id()]);
        }

        public function readNewPosts() {
            return $this->db->select("select type, text, username, fname, postdate as stamp ".
                                     "from post join follow f using(userid) join user using(userid) join (select 'post' as type) z ".
                                     "where postdate >= (now() - interval 1 day) and f.followerid = :followerid and access > 0", 
                                     [":followerid" => User::id()]);
        }

        public function readNewReviews() {
            return $this->db->select("select type, r.review, r.rating, cid, cname, username, fname, reviewdate as stamp ".
                                     "from review r join user u on u.userid = r.userid join concert using(cid) ".
                                     "join follow f on f.userid = u.userid join (select 'review' as type) z ".
                                     "where reviewdate >= (now() - interval 1 day) and f.followerid = :followerid", [":followerid" => User::id()]);
        }

        public function readNewLists() {
            return $this->db->select("select type, listid, listname, username, fname, listdate as stamp ".
                                     "from userlist join user using(userid) ".
                                     "join follow f using(userid) join (select 'list' as type) z ".
                                     "where listdate >= (now() - interval 1 day) and f.followerid = :followerid", [":followerid" => User::id()]);
        }

        public function readSubGenres($table, $key, $concertid) {
            $col = $table == "concert" ? "cid" : "userid";
            $colval = $table == "concert" ? $concertid : User::id();
            return $this->db->select("select subcatid, subcatname from subcategory join category using(catid) ".
            "where (subcatname like :key or catname like :key) and ".
            "subcatid not in (select subcatid from ".$table."genre where $col = :$col) ".
            "limit 5", [":key" => '%'.$key.'%', ":$col" => $colval]);
        }

        public function createConcert($data) {
            $data['userid'] = User::id();
            $this->db->insert("concert", $data);
            return $this->db->lastInsertId();
        }

        public function createPost($userid, $text, $visi) {
            return $this->db->insert("post", ["userid"=>$userid, "text"=>$text, "access"=>$visi]);
        }

        public function createList($listname) {
            $this->db->insert("userlist", ["listname" => $listname, "userid" => User::id() ]);
        }

        public function createFollow($userid) {
            $this->db->insert("follow", ["userid" => $userid, "followerid" => User::id()]);
        }

        public function createSubGenre($table, $subcatid, $concertid) {
            $col = $table == "concert" ? "cid" : "userid";
            $colval = $table == "concert" ? $concertid : User::id();
            $this->db->insert($table."genre", [$col => $colval, "subcatid" => $subcatid]);
        }

        public function createBand($bname, $catid) {
            $this->db->insert("band", ["bname" => $bname, "catid" => $catid]);
            $id = $this->db->lastInsertId();
            $this->db->insert("artist", ["userid" => User::id(), "bandid" => $id]);
        }

        public function deleteSubGenre($table, $subcatid, $concertid) {
            $col = $table == "concert" ? "cid" : "userid";
            $colval = $table == "concert" ? $concertid : User::id();
            $this->db->delete($table."genre", "subcatid = '$subcatid' and $col = '$colval'");
        }

        public function deleteList($listid) {
            $this->db->delete("userlist", "userid = ".User::id()." and listid = $listid");
        }

        public function deletePost($postid) {
            $this->db->delete("post", "postid = $postid");
        }

        public function deleteReview($reviewid) {
            $this->db->delete("review", "reviewid = $reviewid");
        }

        public function deleteFollow($userid) {
            $this->db->delete("follow", "followerid = ".User::id()." and userid = $userid");
        }

        public function deleteFromList($cid, $listid) {
            $this->db->delete("list", "cid = $cid and listid = $listid");
        }

        public function countFollowers($userid) {
            return $this->db->select("select count(*) as n from follow where userid = :userid", [":userid" => $userid]);
        }

        public function countFollowing($userid) {
            return $this->db->select("select count(*) as n from follow where followerid = :userid", [":userid" => $userid]);
        }        

        public function setDetails($data) {
            $data["userid"] = User::id();
            $this->db->update("user", $data, "userid = :userid");
        }
    }
?>