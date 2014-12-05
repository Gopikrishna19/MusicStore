<?php
    class Profile extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");
    
            $this->view->css[] = "profile";
            $this->view->css[] = "leftpanel";
            $this->view->js[] = "editdiag";
            $this->view->js[] = "profile";

            $this->view->foreign = FALSE;            
        }
    
        /* page controllers */
        public function index() {
            $this->view->css[] = "news";

            $arr = $this->model->readNewConcerts();
            $arr = array_merge($arr, $this->model->readNewRecommends());
            $arr = array_merge($arr, $this->model->readNewPosts());
            $arr = array_merge($arr, $this->model->readNewReviews());
            $arr = array_merge($arr, $this->model->readNewLists());

            usort($arr, function($a, $b) {
                return strtotime($b["stamp"]) - strtotime($a["stamp"]);
            });

            $this->view->entries = $arr;

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function of($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);

            $userid = User::toId($username);

            $this->view->user = $this->model->readUser($userid);
            $this->view->taste = $this->model->readUserGenre($userid);
            $this->view->isfollowing = User::isFollower($username);
            $this->view->followers = $this->model->countFollowers($userid)[0]["n"];
            $this->view->following = $this->model->countFollowing($userid)[0]["n"];

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function posts($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);
    
            $access = User::isOwner($username) ? 0 : (User::isFollower($username) ? 1 : 2);            
            $this->view->posts = $this->model->readPosts($username, $access);            
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function reviews($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);
    
            $this->view->reviews = $this->model->readReviews($username);
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function concerts($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);
    
            $this->view->by = $this->model->readBy($username);
            if(User::isOwner($username) || User::isFollower($username)) {
                $this->view->attended = $this->model->readAttend($username, 1);
                $this->view->attending = $this->model->readAttend($username);
            }

            $this->view->venues = $this->model->readVenues();
            $this->view->bands = $this->model->readBands();
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function bands($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);

            $this->view->artist = $this->model->readArtist($username);
            if(User::isOwner($username) || User::isFollower($username)) {
                $this->view->fan = $this->model->readFan($username);
            }
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function lists($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);

            $this->view->lists = $this->model->readLists($username);
            
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function viewlist($username = NULL, $listid = NULL) {
            if($username == NULL || $listid == NULL) {
                $this->lists();
                return;
            }
            $this->setForeign($username);

            $this->view->listname = $this->model->readListName($listid)[0]["listname"];
            if($this->view->listname == NULL) {
                $error = new Error(404);
                $error->index();
                return;
            }
            $this->view->concerts = $this->model->readListConcerts($listid);
            $this->view->listid = $listid;

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function network($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->setForeign($username);

            $this->view->following = $this->model->readFollow($username);
            $this->view->follower = $this->model->readFollow($username, TRUE);
            
            if($this->view->foreign) {
                $this->view->mfollowing = $this->model->readFollow($username, FALSE, TRUE);
                $this->view->mfollower = $this->model->readFollow($username, TRUE, TRUE);
            }
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function settings() {
            $this->view->user = $this->model->readUser(User::id());
            $this->view->taste = $this->model->readUserGenre(User::id());
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        /* ajax handlers */
        public function xhrCreatePost() {
            $this->model->createPost(User::id(),$_POST["text"],$_POST["visi"]);
        }

        public function xhrDeletePost($postid) {
            $this->model->deletePost($postid);
        }

        public function xhrDeleteReview($reviewid) {
            $this->model->deleteReview($reviewid);
        }

        public function xhrChangePassword() {
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->model->setDetails(["password" => Hash::digest($_POST["password"])]);
                echo "done";
            }
        }

        public function xhrChangeDetails() {
            $this->model->setDetails($_POST);
            echo "done";
        }

        public function xhrSubGenres($table, $concertid = NULL) {
            echo json_encode($this->model->readSubGenres($table, $_GET["key"], $concertid));
        }

        public function xhrRemoveGenre($table, $subcatid, $concertid = NULL) {
            $this->model->deleteSubGenre($table, $subcatid, $concertid);
        }

        public function xhrAddGenre($table, $subcatid, $concertid = NULL) {
            $this->model->createSubGenre($table, $subcatid, $concertid);
        }

        public function xhrCreateConcert() {
            $arr = $_POST;

            if($arr["ticket"]=="") unset($arr["ticket"]);
            if($arr["url"]=="") unset($arr["url"]);
            
            $arr['ctime'] = date("Y-m-d H:i:s", strtotime($arr['ctime1']." ".$arr['ctime2']));
            unset($arr['ctime1']);
            unset($arr['ctime2']);

            print_r($this->model->createConcert($arr));
        }

        public function xhrCreateList($listname) {
            $this->model->createList($listname);
        }

        public function xhrDeleteList($listid) {
            $this->model->deleteList($listid);
        }

        public function xhrCreateFollow($userid) {
            $this->model->createFollow($userid);
        }

        public function xhrDeleteFollow($userid) {
            $this->model->deleteFollow($userid);
        }

        public function xhrDeleteFromList($cid, $listid) {
            $this->model->deleteFromList($cid, $listid);
        }
    
        /* private functions */
        private function setForeign($username) {
            if(!User::isOwner($username)) {
                $this->view->foreign = TRUE;
                $this->view->foreignUN = $username;   
            }
        }
    }
?>
