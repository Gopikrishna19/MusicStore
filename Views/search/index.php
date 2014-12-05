<?php $curr="rec"; require "Views/master/searchpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if($this->concerts != NULL): $nothing = FALSE; ?>
    <div class="section-title">Concerts</div>
    <div class="section band">
        <?php
            foreach($this->concerts as $entry) 
                ActionLink::create("<div class='icon'></div>".$entry["cname"], "concert", "view", $entry["cid"], NULL, "article link");
        ?>
    </div>
    <?php endif; ?>
    
    <?php if($this->bands != NULL): $nothing = FALSE; ?>
    <div class="section-title">Bands</div>
    <div class="section band">
        <?php
            foreach($this->bands as $entry) 
                ActionLink::create("<div class='icon'></div>".$entry["bname"], "band", "view", $entry["bandid"], NULL, "article link");
        ?>
    </div>
    <?php endif; ?>

    <?php if($this->people != NULL): $nothing = FALSE; ?>
    <div class="section-title">People</div>
    <div class="section people">
        <?php
            foreach($this->people as $entry) 
                ActionLink::create("<div class='icon'></div>".(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]), 
                                        "profile", "of", $entry["username"], NULL, "article link");
        ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">
        Sorry, nothing to recommend.
    </div>
    <?php endif; ?>
</div>