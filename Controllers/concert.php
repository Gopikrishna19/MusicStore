<?php
    class Concert extends Controller {
        public function __construct() {
            parent::__construct();
            if(!User::name())
                header("Location: /home/logout");
    
            $this->view->css[] = "concert";
            $this->view->js[] = "concert";
            $this->view->js[] = "editdiag";
        }
    
        public function index() {
            $genre = NULL;
            $gname = NULL;
            $filter = FALSE;
            $where = "";
            if(isset($_GET["genre"])) {
                $genre = $_GET["genre"];
                $filter = TRUE;
                $where = " and cid in (select cid from concertgenre where subcatid = :subcatid)";
                $gname = $this->model->getGenreName($genre);
            }
    
            $this->view->genre = $gname[0]["subcatname"];
            $this->view->genres = $this->model->getSubGenres();
            $this->view->come = $this->model->getConcerts("where ctime > CURRENT_TIMESTAMP".$where." order by ctime asc", $filter, $genre);
            $this->view->done = $this->model->getConcerts("where ctime <= CURRENT_TIMESTAMP".$where." order by ctime desc", $filter, $genre);
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function view($cid = NULL) {
            if($cid == NULL) {
                $this->index();
                return;
            }
            $this->view->concert = $this->model->getConcert($cid);
            if($this->view->concert == NULL) {
                $error = new Error(404);
                $error->index();
                return;
            }
    
            $this->view->isConcertOwner = $this->model->isConcertOwner($cid) != NULL;
            $this->view->genres = $this->model->getConcertGenres($cid);
            $this->view->reviews = $this->model->getReviews($cid);
    
            $this->view->isApprove = FALSE;
            if(!$this->view->isConcertOwner && $this->view->concert[0]["approved"] == 0) {
                $this->view->isApprove = $this->model->isValidApprover($cid) != NULL;                
            }
    
            $this->view->venues = $this->model->readVenues();
            $this->view->bands = $this->model->readBands();

            $ctime = strtotime($this->view->concert[0]["ctime"]);
            $attend = $this->model->getAttend($cid);

            $this->view->lists = $this->model->getUserLists();            
    
            // 0 -> past and not reserved, 1 -> not attending, 2 -> attending, 3 -> reserved but not attended, 4 -> attended
            if(time() < $ctime) {
                $this->view->attend = $attend != NULL ? 2 : 1;
            } elseif(time() >= $ctime) {
                $this->view->attend = $attend != NULL ? ($attend[0]["attended"] == 0 ? 3 : 4) : 0;
            }            
    
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    
        public function xhrAddReview() {
            $this->model->createReview($_POST);
        }
    
        public function xhrApprove($cid) {
            $this->model->setApprove($cid);
        }
    
        public function xhrRecommend($cid) {
            $this->model->createRecommend($cid);
        }
    
        public function xhrDeleteConcert($cid) {
            $this->model->deleteConcert($cid);
        }

        public function xhrAttendConcert($cid, $mode) {            
            switch($mode) {
                case 0: break;
                case 1: $this->model->createAttend($cid); break;
                case 2: $this->model->deleteAttend($cid); break;
                case 3: $this->model->setAttended($cid, 1); break;
                case 4: $this->model->setAttended($cid, 0); break;
            }
        }

        public function xhrSaveConcert() {
            $arr = $_POST;

            if($arr["ticket"]=="") $arr["ticket"] = NULL;
            if($arr["url"]=="") $arr["url"] = NULL;
            
            $arr['ctime'] = date("Y-m-d H:i:s", strtotime($arr['ctime1']." ".$arr['ctime2']));
            unset($arr['ctime1']);
            unset($arr['ctime2']);

            $this->model->setConcert($arr);
        }

        public function xhrAddToList($cid, $listid) {
            echo $this->model->addToList($cid, $listid);
        }
    }
?>
