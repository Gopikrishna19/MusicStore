<?php $curr="net"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if($this->following != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am Following</div>
    <div class="section by">
        <?php foreach($this->following as $entry): ?>
        <div class="entry block follow" data-id="<?php echo $entry["userid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
            <ul class="options">
                <li class="go" title="View Profile"><?php ActionLink::create("","profile","of",$entry["username"],NULL,"go"); ?></li>
                <li class="rm" title="Unfollow"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($this->follower != NULL): $nothing = FALSE; ?>
    <div class="section-title">Following Me</div>
    <div class="section by">
        <?php foreach($this->follower as $entry): ?>
        <div class="entry block follow" data-id="<?php echo $entry["userid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
            <ul class="options">
                <li class="go" title="View Profile"><?php ActionLink::create("","profile","of",$entry["username"],NULL,"go"); ?></li>
                <li class="rm" title="Unfollow"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->mfollowing) && $this->mfollowing != NULL): $nothing = FALSE; ?>
    <div class="section-title">Mutually Following</div>
    <div class="section by">
        <?php foreach($this->mfollowing as $entry): ?>
        <div class="entry block follow" data-id="<?php echo $entry["userid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
            <ul class="options">
                <li class="go" title="View Profile"><?php ActionLink::create("","profile","of",$entry["username"],NULL,"go"); ?></li>
                <li class="rm" title="Unfollow"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->mfollower) && $this->mfollower != NULL): $nothing = FALSE; ?>
    <div class="section-title">Mutual Followers</div>
    <div class="section by">
        <?php foreach($this->mfollower as $entry): ?>
        <div class="entry block follow" data-id="<?php echo $entry["userid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
            <ul class="options">
                <li class="go" title="View Profile"><?php ActionLink::create("","profile","of",$entry["username"],NULL,"go"); ?></li>
                <li class="rm" title="Unfollow"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no connections to display.</div>
    <?php endif; ?>
</div>