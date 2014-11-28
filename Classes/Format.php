<?php
    class Format {
        public static function prettyDate($date) {
            return date("g:i A, M d, Y", strtotime($date));
        }
    }
?>