<?php
    class Format {
        public static function prettyDateTime($date) {
            return date("g:i A, M d, Y", strtotime($date));
        }

        public static function prettyDate($date) {
            return date("M d, Y", strtotime($date));
        }

        public static function prettyTime($date) {
            return date("g:i A", strtotime($date));
        }
    }
?>