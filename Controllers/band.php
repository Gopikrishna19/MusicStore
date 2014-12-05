<?php
    class Band extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");
    
            $this->view->css[] = "concert";
            $this->view->js[] = "band";
        }
    
        public function index() {
            $genre = NULL;
            $gname = NULL;
            $filter = FALSE;
            $where = "";
            if(isset($_GET["genre"]) && $_GET["genre"] != "") {
                $genre = $_GET["genre"];
                $filter = TRUE;
                $where = " and catid = :catid";
                $gname = $this->model->getGenreName($genre);
            }
    
            $this->view->genre = $gname[0]["catname"];
            $this->view->genres = $this->model->getGenres();
            $this->view->bands = $this->model->getBands("where 1".$where, $filter, $genre);            
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function view($bandid = NULL) {
            if($bandid == NULL) {
                $this->index();
                return;
            }
            $this->view->band = $this->model->getBand($bandid);
            if($this->view->band == NULL) {
                $error = new Error(404);
                $error->index();
                return;
            }
    
            $this->view->artists = $this->model->getArtists($bandid);
            $this->view->fans = $this->model->countFans($bandid)[0]["n"];
            $this->view->come = $this->model->getConcerts($bandid, " and ctime > CURRENT_TIMESTAMP order by ctime asc");
            $this->view->done = $this->model->getConcerts($bandid, " and ctime <= CURRENT_TIMESTAMP order by ctime desc");
            $this->view->isfan = $this->model->isFan($bandid) != NULL;
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function xhrCreateFan($bandid) {
            $this->model->createFan($bandid);
        }

        public function xhrDeleteFan($bandid) {
            $this->model->deleteFan($bandid);
        }
    }
?>
