<?php $curr="peop"; require "Views/master/searchpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php require "Views/master/searchbox.php"; ?>

    <?php if($this->people != NULL): $nothing = FALSE; ?>
    <div class="section-title">Results</div>
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
        Sorry, nothing found matching the search.
    </div>
    <?php endif; ?>
</div>