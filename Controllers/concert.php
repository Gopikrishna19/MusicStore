<?php
    class Concert extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");
        }
    
        public function view($cid) {

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    }
?>
