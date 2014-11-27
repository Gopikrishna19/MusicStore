<?php
    class Profile extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");

            $this->view->css[] = "profile";
            $this->view->css[] = "leftpanel";
            $this->view->js[] = "profile";
        }
    
        public function index() {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function of($username) {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function posts($username = NULL) {
            $username = $username == NULL ? User::name() : $username;
            $this->view->posts = $this->model->readPosts($username);

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function reviews($username = NULL) {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function concerts($username = NULL) {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function follow($username = NULL) {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function xhrCreatePost() {
            print_r($this->model->createPost(User::id(),$_POST["text"],$_POST["visi"]));
        }
    }
?>
