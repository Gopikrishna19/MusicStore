<div class="content">
    <form class="filter">
        <label>Filter:</label>
        <select name="genre" class="txt">
            <option></option>
            <?php foreach($this->genres as $genre): ?>
            <option value="<?php echo $genre["subcatid"]; ?>" <?php echo $this->genre == $genre["subcatname"] ? "selected" : ""; ?>>
                <?php echo $genre["subcatname"]; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php if($this->genre != NULL) { ?>
    <?php ActionLink::create("&#8592; View All Concerts","concert",NULL,NULL,NULL,"link clear-both"); ?>
    <div class="section-filter">Filter by "<?php echo $this->genre; ?>"</div>
    <?php } ?>
    <?php if($this->come != NULL): $nothing = FALSE; ?>
    <div class="section-title">Upcoming Concerts</div>
    <div class="section by">
        <?php foreach($this->come as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($this->done != NULL): $nothing = FALSE; ?>
    <div class="section-title">Past Concerts</div>
    <div class="section by">
        <?php foreach($this->done as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
