<?php
    class Home extends Controller {
        public function __construct() {
            parent::__construct();
            $this->view->css[] = "home";
            $this->view->js[] = "home";
            $this->view->setHeader("header-home");
        }
    
        public function index() {
            if(User::name())
                header("Location: /profile");
            else
                $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function register() {            
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function forgot() {
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function logout() {
            Session::stop();
            header("Location: /home");
        }
    
        public function xhrCheckUser($username, $password = NULL) {
            echo $this->model->checkUserExists($username, $password);
        }

        public function xhrCreateUser($username, $password) {
            echo $this->model->createUser($username, $password);
        }
    }
?>
