<?php
    class Profile extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");
    
            $this->view->css[] = "profile";
            $this->view->css[] = "leftpanel";
            $this->view->js[] = "profile";

            $this->view->foreign = FALSE;
        }
    
        public function index() {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function of($username) {
            $this->setForeign($username);
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
                $this->view->attended = $this->model->readAttend($username);
                $this->view->attending = $this->model->readAttend($username, 1);
            }
    
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
    
        public function xhrCreatePost() {
            print_r($this->model->createPost(User::id(),$_POST["text"],$_POST["visi"]));
        }
    
        private function setForeign($username) {
            if(!User::isOwner($username)) {
                $this->view->foreign = TRUE;
                $this->view->foreignUN = $username;   
            }
        }
    }
?>
