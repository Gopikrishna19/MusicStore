<?php $curr="news"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php
        foreach($this->entries as $entry) {
            $nothing = FALSE;
            switch($entry["type"]) {
                case "concert":
    ?>
    <div class="article concert">
        <div class="icon"></div>
        <div class="user">
            <?php
                ActionLink::create(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"], 
                                                    "profile", "of", $entry["username"], NULL, "link");
            ?>
            created a new concert on <?php echo Format::prettyDateTime($entry["stamp"]); ?>
        </div>
        <div class="concert">
            <?php ActionLink::create($entry["cname"], "concert", "view", $entry["cid"], NULL, "link"); ?>
        </div>
    </div>
    <?php
        break;
        case "recommend":
    ?>
    <div class="article recommend">
        <div class="icon"></div>
        <div class="user">
            <?php
                ActionLink::create(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"], 
                                                    "profile", "of", $entry["username"], NULL, "link");
            ?>
            recommended the concert on <?php echo Format::prettyDateTime($entry["stamp"]); ?>
        </div>
        <div class="concert"><?php ActionLink::create($entry["cname"], "concert", "view", $entry["cid"], NULL, "link"); ?></div>
    </div>
    <?php
        break;
        case "post":
    ?>
    <div class="article post">
        <div class="user">
            <?php
                ActionLink::create(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"], 
                                                    "profile", "of", $entry["username"], NULL, "link");
            ?>
            posted on <?php echo Format::prettyDateTime($entry["stamp"]); ?>
        </div>
        <div class="text"><?php echo $entry["text"]; ?></div>
    </div>
    <?php
        break;
        case "review":
    ?>
    <div class="article review">
        <div class="user">
            <?php
                ActionLink::create(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"], 
                                                    "profile", "of", $entry["username"], NULL, "link");
            ?>
            wrote a review about
            <?php ActionLink::create($entry["cname"], "concert", "view", $entry["cid"], NULL, "link"); ?>
            on <?php echo Format::prettyDateTime($entry["stamp"]); ?>
        </div>
        <div class="text"><?php echo $entry["review"]; ?></div>
        <div class="rating" data-rate="<?php echo $entry["rating"]; ?>"></div>
    </div>
    <?php
        break;
        case "list":
    ?>
    <div class="article list">
        <div class="icon"></div>
        <div class="user">
            <?php
                ActionLink::create(trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"], 
                                                    "profile", "of", $entry["username"], NULL, "link");
            ?>
            created a new concert list on <?php echo Format::prettyDateTime($entry["stamp"]); ?>
        </div>
        <div class="concert">
            <?php ActionLink::create($entry["listname"], "profile", "viewlist", 
                                        $entry["username"]."/".$entry["listid"], NULL, "link"); ?>
        </div>
    </div>
    <?php
        break;
            }
        }
    ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there is nothing new to display.</div>
    <?php endif; ?>
</div>