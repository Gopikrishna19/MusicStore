<?php $curr="rev"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php foreach($this->reviews as $row => $rev): $nothing = FALSE; ?>
    <div class="block review">
        <?php if(!$this->foreign) { ?><div class="delete" data-id="<?php echo $rev["reviewid"]; ?>">delete</div><?php } ?>
        <div class="about">
            About <?php ActionLink::create($rev["cname"],"concert","view",$rev["cid"],NULL,"link"); ?>
            <div class="stamp">on <?php echo Format::prettyDateTime($rev["reviewdate"]); ?></div></div>
        <div class="text"><?php echo $rev["review"]; ?></div>
        <div class="rating" data-rate="<?php echo $rev["rating"]; ?>"></div>
    </div>
    <?php endforeach; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no reviews to display.</div>
    <div>Write reviews on concerts you attended to show them here</div>
    <?php endif; ?>
</div>