<?php $curr="band"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if($this->artist != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am an Artist In</div>
    <div class="section by">
        <?php foreach($this->artist as $entry): ?>
        <div class="entry block band" data-cid="<?php echo $entry["bandid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["bname"]; ?></div>            
            <ul class="options">
                <li class="go" title="Open"><?php ActionLink::create("","band","view",$entry["bandid"],NULL,"go"); ?></li>
                <li class="rm" title="Delete"></li>                
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->fan) && $this->fan != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am a Fan of</div>
    <div class="section by">
        <?php foreach($this->fan as $entry): ?>
        <div class="entry block band" data-cid="<?php echo $entry["bandid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["bname"]; ?></div>            
            <ul class="options">
                <li class="go" title="Open"><?php ActionLink::create("","band","view",$entry["bandid"],NULL,"go"); ?></li>
                <li class="rm" title="Delete"></li>                
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>