<?php $curr="band"; require "Views/master/searchpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php require "Views/master/searchbox.php"; ?>

    <?php if($this->bands != NULL): $nothing = FALSE; ?>
    <div class="section-title">Results</div>
    <div class="section band">
        <?php
            foreach($this->bands as $entry) 
                ActionLink::create("<div class='icon'></div>".$entry["bname"], "band", "view", $entry["bandid"], NULL, "article link");
        ?>
    </div>
    <?php endif; ?>
    <?php if($nothing): ?>
    <div class="section-title empty">
        Sorry, nothing found matching the search.
    </div>
    <?php endif; ?>
</div>