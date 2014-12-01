<?php
    class Concert extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");

            $this->view->css[] = "concert";
        }

        public function index() {
            $this->view->concerts = $this->model->getConcerts();
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function view($cid) {
            $this->view->concert = $this->model->getConcert($cid);
            if($this->view->concert == NULL) {
                $error = new Error(404);
                $error->index();
                die;
            }

            $this->view->reviews = $this->model->getReviews($cid);

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    }
?>
