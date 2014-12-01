<?php $concert = $this->concert[0]; ?>
<div class="content">
    <div class="left">
        <div class="icon"></div>
        <div class="stamp">
            Created by
            <?php
                ActionLink::create(trim($concert["fname"]) == "" ? $concert["username"] : $concert["fname"], "profile", "of", $concert["username"], NULL, "link");
            ?>
            on <?php echo Format::prettyDateTime($concert["created"]); ?>
        </div>
        <div class="title"><?php echo $concert["cname"]; ?></div>
        <?php if($concert["approved"] == 0): ?><div class="approve">Not Yet Approved</div>
        <?php else: ?><div class="approve yes">Approved</div><?php endif; ?>
        <div class="label band"><?php echo $concert["bname"]; ?></div>
        <div class="label date"><?php echo Format::prettyDate($concert["ctime"]); ?></div>
        <div class="label time"><?php echo Format::prettyTime($concert["ctime"]); ?></div>
        <div class="label venue"><?php echo $concert["venuename"]; ?></div>

        <?php if($concert["url"] != NULL) { ?><div class="link">Url: <?php echo $concert["url"]; ?></div> <?php } ?>
        <?php if($concert["ticket"] != NULL) { ?><div class="link">Book Ticket: <?php echo $concert["ticket"]; ?></div> <?php } ?>

        <div class="rating"></div>
    </div>
    <div class="right"><?php $nothing = TRUE; $rating = 0; ?>
        <?php foreach($this->reviews as $row => $rev): $nothing = FALSE; ?>
        <div class="block post">
            <div class="stamp">on <?php echo Format::prettyDateTime($rev["reviewdate"]); ?></div>
            <div class="text"><?php echo $rev["review"]; ?></div>
            <div class="rating" data-rate="<?php echo $rev["rating"]; ?>"></div>
            <?php $rating += $rev["rating"]; ?>
        </div>
        <?php endforeach; ?>

        <?php if($nothing): ?>
        <div class="section-title empty">Sorry, there are no reviews to display.</div>
        <?php endif; ?>
    </div>
</div>
<script>
    window.$rating = <?php echo $nothing ? 0 : $rating / sizeof($this->reviews); ?>;    
</script>
<script>
    $(function () {
        $(".rating").rating();
        $(".left .rating").ratingAttr(Math.round($rating));
        console.log($rating);
    });
</script>