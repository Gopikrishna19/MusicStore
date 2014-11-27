<?php
    require "Assets/config.php";
    require_once "Controllers/error.php";

    function __autoload($class) {
        require "Classes/$class.php";
    }

    new Boot();
?>