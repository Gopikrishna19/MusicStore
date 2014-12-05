<?php
    class Model {
        public function __construct(){
            $this->db = new Database();
        }
    
        public function readVenues() {
            return $this->db->select("select * from venue");
        }
    
        public function readBands() {
            return $this->db->select("select * from band");
        }

        public function getSubGenres() {
            return $this->db->select("select * from subcategory order by subcatname");
        }

        public function getGenres() {
            return $this->db->select("select * from category order by catname");
        }
    }
?>