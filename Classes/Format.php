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

        public static function stdDate($date) {
            return date("Y-m-d", strtotime($date));
        }

        public static function stdTime($date) {
            return date("H:i", strtotime($date));
        }
    }
?>