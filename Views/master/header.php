<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes.php"; ?>
    </head>
    <body>
        <div class="header">
            <div class="wrapper">
                <ul class="right">
                    <li><?php ActionLink::create("Search","search",NULL,NULL,NULL,"menu"); ?></li>
                    <li><?php ActionLink::create("My Profile","profile","of",User::name(),NULL,"menu"); ?></li>
                    <li><?php ActionLink::create("Log Out","home","logout",NULL,NULL,"menu"); ?></li>
                </ul>
                <a class="title" href="./"><img class="icon" src="/Assets/img/music.png">Music Share</a>
            </div>
        </div>
        <div class="body">
