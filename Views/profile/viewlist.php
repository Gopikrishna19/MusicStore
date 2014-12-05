<?php $curr="list"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php ActionLink::create("&#8592; View All Lists","profile","lists",$funame,NULL,"link"); ?>

    <div class="section-title" style="margin-top: 25px;"><?php echo $this->listname; ?>
        <?php if(!$this->foreign) { ?>
        <button class="edit deletelist" data-id="<?php echo $this->listid; ?>">Delete List</button>
        <?php } ?>
    </div>
    <?php if($this->concerts != NULL): $nothing = FALSE; ?>
    <div class="section list">
        <?php foreach($this->concerts as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <?php if(!$this->foreign) { ?><div class="delete" data-id="<?php echo $entry["cid"]."/".$this->listid; ?>">delete</div><?php } ?>
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no concerts to display.</div>
    <?php ActionLink::create("View All Concerts &#8594;","concert",NULL,NULL,NULL,"link clear-both"); ?>
    <?php endif; ?>
</div>