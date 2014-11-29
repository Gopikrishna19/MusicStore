<?php $curr="con"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if($this->by != NULL): $nothing = FALSE; ?>
    <div class="section-title">Posted by Me</div>
    <div class="section by">
        <?php foreach($this->by as $entry): ?>
        <div class="entry block concert" data-id="<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDate($entry["created"]); ?></div>
            <ul class="options">
                <li class="go" title="Open"><?php ActionLink::create("","concert","view",$entry["cid"],NULL,"go"); ?></li>
                <li class="rm" title="Delete"></li>
                <li class="at" title="Reserve"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->attending) && $this->attending != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am Attending</div>
    <div class="section attin">
        <?php foreach($this->attending as $entry): ?>
        <div class="entry block concert" data-id="<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="concert-name"><?php echo $entry["cname"]; ?></div>
            <div class="concert-stamp">Time: <?php echo Format::prettyDate($entry["ctime"]); ?></div>
            <ul class="options">
                <li class="go" title="Open"><?php ActionLink::create("","concert","view",$entry["cid"],NULL,"go"); ?></li>
                <li class="rm" title="Cancel"></li>
                <li class="dn" title="Mark as Attended"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->attended) && $this->attended != NULL): $nothing = FALSE ?>
    <div class="section-title">I have Attended</div>
    <div class="section atted">
        <?php foreach($this->attended as $entry): ?>
        <div class="entry block concert" data-id="<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="concert-name"><?php echo $entry["cname"]; ?></div>
            <div class="concert-stamp">Time: <?php echo Format::prettyDate($entry["ctime"]); ?></div>
            <ul class="options">
                <li class="go" title="Open"><?php ActionLink::create("","concert","view",$entry["cid"],NULL,"go"); ?></li>
                <li class="rm" title="Mark as Not Attended"></li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no concerts to display.</div>
    <?php endif; ?>
</div>