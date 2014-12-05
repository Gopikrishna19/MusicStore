<div class="content">
    <form class="filter">
        <label>Filter:</label>
        <select name="genre" class="txt">
            <option></option>
            <?php foreach($this->genres as $genre): ?>
            <option value="<?php echo $genre["catid"]; ?>" <?php echo $this->genre == $genre["catname"] ? "selected" : ""; ?>>
                <?php echo $genre["catname"]; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php $nothing = TRUE; ?>
    <?php if($this->genre != NULL) { ?>
    <?php ActionLink::create("&#8592; View All Bands","band",NULL,NULL,NULL,"link clear-both"); ?>
    <div class="section-filter">Filter by "<?php echo $this->genre; ?>"</div>
    <?php } ?>
    <div class="section-title">Bands</div>
    <?php if($this->bands != NULL): $nothing = FALSE; ?>
    <div class="section band">
        <?php foreach($this->bands as $entry): ?>
        <a class="entry block band" href="/band/view/<?php echo $entry["bandid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["bname"]; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no bands to display.</div>
    <?php endif; ?>
</div>
