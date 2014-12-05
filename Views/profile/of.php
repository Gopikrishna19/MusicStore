<?php $curr="prof"; require "Views/master/leftpanel.php"; $user = $this->user[0] ?>
<div class="content">
    <div class="icon"></div>
    <div class="section-title">
        <?php
            $uname = $user["fname"]." ".$user["lname"]; 
            echo trim($uname) == "" ? $user["username"] : $uname;
        ?>
    </div>
    <div class="section">
        <div class="label from"><?php echo Format::prettyDate($user["joindate"]); ?></div>
        <?php if(trim($user["city"]) != "") { ?><div class="label city"><?php echo $user["city"]; ?></div><?php } ?>
        <div class="label followers"><?php echo $this->followers; ?></div>
        <div class="label following"><?php echo $this->following; ?></div>
        <div class="rating" data-rate="<?php echo round($user["rating"]/2); ?>"></div>
        <?php if($this->foreign) { ?>
        <div class="options">
            <?php if($this->isfollowing): ?>
            <button data-id="<?php echo $user["userid"]; ?>" class="follow yes">Unfollow</button>
            <?php else: ?>
            <button data-id="<?php echo $user["userid"]; ?>" class="follow">Follow</button>
            <?php endif; ?>
        </div>
        <?php } ?>
    </div>
    <?php if($this->taste != NULL): ?>
    <div class="section-title" style="margin-top: 25px">Favourite Genres</div>
    <div class="section">
        <?php
            foreach($this->taste as $entry){              
                ActionLink::create($entry["subcatname"],"concert",NULL,NULL,["genre" => $entry["subcatid"]],"genre");
            }
        ?>
    </div>
    <?php endif; ?>
</div>