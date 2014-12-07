<?php $curr="band"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php ActionLink::create("View All Bands &#8594;","band",NULL,NULL,NULL,"link clear-both"); ?>
    <!--<?php if(!$this->foreign) { ?>
    <div class="section-title"><button class="edit band">Click here to create a new band</button></div>
    <?php } ?>-->
    <?php if($this->artist != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am an Artist In</div>
    <div class="section band">
        <?php foreach($this->artist as $entry): ?>
        <a class="entry block band" href="/band/view/<?php echo $entry["bandid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["bname"]; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->fan) && $this->fan != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am a Fan of</div>
    <div class="section band">
        <?php foreach($this->fan as $entry): ?>
        <a class="entry block band" href="/band/view/<?php echo $entry["bandid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["bname"]; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no bands to display.</div>
    <div>Click "Search" to find new bands</div>
    <?php endif; ?>
</div>
<div id="edit-band" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form band">
                <form class="band">
                    <input type="text" class="txt listname" placeholder="Band Name">
                    <select class="txt">
                        <option></option>
                        <?php foreach($this->genres as $genre): ?>
                        <option value="<?php echo $genre["catid"]; ?>">
                            <?php echo $genre["catname"]; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <p>You will be automatically added as artist in the band.</p>
                    <input type="button" class="link cancel" value="Cancel">
                    <input type="submit" class="btn" value="Create">
                </form>
            </div>
        </div>
    </div>
</div>