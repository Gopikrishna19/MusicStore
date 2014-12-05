<?php $curr="net"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if($this->following != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am Following</div>
    <div class="section flin">
        <?php foreach($this->following as $entry): ?>
        <a class="entry block follow" href="/profile/of/<?php echo $entry["username"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($this->follower != NULL): $nothing = FALSE; ?>
    <div class="section-title">Following Me</div>
    <div class="section fler">
        <?php foreach($this->follower as $entry): ?>
        <a class="entry block follow" href="/profile/of/<?php echo $entry["username"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>            
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->mfollowing) && $this->mfollowing != NULL): $nothing = FALSE; ?>
    <div class="section-title">Mutually Following</div>
    <div class="section mflin">
        <?php foreach($this->mfollowing as $entry): ?>
        <a class="entry block follow" href="/profile/of/<?php echo $entry["username"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->mfollower) && $this->mfollower != NULL): $nothing = FALSE; ?>
    <div class="section-title">Mutual Followers</div>
    <div class="section mfler">
        <?php foreach($this->mfollower as $entry): ?>
        <a class="entry block follow" href="/profile/of/<?php echo $entry["username"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo trim($entry["fname"]) == "" ? $entry["username"] : $entry["fname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["followdate"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no connections to display.</div>
    <div>Click "Search" to find new people to connect to</div>
    <?php endif; ?>
</div>