<?php
    class Search extends Controller {
        public function __construct() {
            parent::__construct();

            $this->view->css[] = "news";
            $this->view->css[] = "leftpanel";
            $this->view->js[] = "search";
        }

        public function index() {
            $this->view->concerts = $this->model->recommendConcerts();
            $this->view->bands = $this->model->recommendBands();
            $this->view->people = $this->model->recommendPeople();

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function concert() {
            $this->view->key = isset($_GET["key"]) ? $_GET["key"] : "";
            $this->view->genre = isset($_GET["genre"]) ? $_GET["genre"] : "";
            $this->view->date = isset($_GET["date"]) ? $_GET["date"] : "";
            $this->view->creator = isset($_GET["creator"]) ? $_GET["creator"] : "";

            $this->view->genres = $this->model->getGenres();
            $this->view->concerts = $this->model->searchConcerts($this->view->key, $this->view->date, 
                                                                 $this->view->creator, $this->view->genre);

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function band() {
            $this->view->key = isset($_GET["key"]) ? $_GET["key"] : "";
            $this->view->genre = isset($_GET["genre"]) ? $_GET["genre"] : "";
            $this->view->genres = $this->model->getGenres();
            $this->view->bands = $this->model->searchBands($this->view->key, $this->view->genre);

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function people() {
            $this->view->key = isset($_GET["key"]) ? $_GET["key"] : "";
            $this->view->people = $this->model->searchPeople($this->view->key);

            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    }
?>