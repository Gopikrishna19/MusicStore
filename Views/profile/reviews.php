<?php $curr="rev"; require "Views/master/leftpanel.php"; ?>
<div class="content">
    <?php foreach($this->reviews as $row => $rev): ?>
    <div class="block post">
        <div class="rev-concert">
            About <?php ActionLink::create($rev["cname"],"concert","view",$rev["cid"],NULL,"link"); ?>
            <div class="rev-stamp">on <?php echo Format::prettyDate($rev["reviewdate"]); ?></div></div>
        <div class="rev-content"><?php echo $rev["review"]; ?></div>
        <div class="rev-rating rating" data-rate="<?php echo $rev["rating"]; ?>"></div>
    </div>
    <?php endforeach; ?>
</div>