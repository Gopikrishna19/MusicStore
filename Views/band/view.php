<?php $band = $this->band[0]; ?>
<div class="content">
    <?php ActionLink::create("&#8592; View All Bands","band",NULL,NULL,NULL,"link clear-both"); ?>
    <div class="left band">
        <div class="icon band"></div>
        <div class="title"><?php echo $band["bname"]; ?></div>
        <div class="label genre"><?php echo $band["catname"]; ?></div>
        <div class="label fans"><?php echo $this->fans; ?></div>
        <div class="options">
            <?php if($this->isfan): ?>
            <button data-id="<?php echo $band["bandid"]; ?>" class="fan yes">Un-fan</button>
            <?php else: ?>
            <button data-id="<?php echo $band["bandid"]; ?>" class="fan">Become a Fan</button>
            <?php endif; ?>
        </div>
        <?php if($this->artists != NULL): ?>
        <div class="genres">
            <?php
                foreach($this->artists as $artist)
                    ActionLink::create(trim($artist["fname"]) == "" ? $artist["username"] : $artist["fname"], "profile", "of", $artist["username"]);
            ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="right"><?php $nothing = TRUE; ?>
        <?php if($this->come != NULL): ?>
        <div class="section-title">Upcoming Concerts</div>
        <div class="section">
            <?php foreach($this->come as $entry): $nothing = FALSE; ?>
            <a class="entry block concert full" href="/concert/view/<?php echo $entry["cid"]; ?>">
                <div class="icon"></div>
                <div class="name"><?php echo $entry["cname"]; ?></div>
                <div class="stamp">on <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if($this->done != NULL): ?>
        <div class="section-title">Past Concerts</div>
        <div class="section">
            <?php foreach($this->done as $entry): $nothing = FALSE; ?>
            <a class="entry block concert full" href="/concert/view/<?php echo $entry["cid"]; ?>">
                <div class="icon"></div>
                <div class="name"><?php echo $entry["cname"]; ?></div>
                <div class="stamp">on <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if($nothing): ?>
        <div class="section-title empty">Sorry, there are no reviews to display.</div>
        <?php endif; ?>
    </div>
</div>