<div class="leftpanel">
    <?php $funame = $this->foreign ? $this->foreignUN : NULL; ?>
    <ul>
        <?php if(!$this->foreign): ?>
        <li><?php ActionLink::create("News","profile",NULL,NULL,NULL,($curr=="news"?"active":NULL)); ?></li>
        <?php endif; ?>
        <li><?php ActionLink::create("Posts","profile","posts",$funame,NULL,($curr=="post"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Reviews","profile","reviews",$funame,NULL,($curr=="rev"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Concerts","profile","concerts",$funame,NULL,($curr=="con"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Bands","profile","bands",$funame,NULL,($curr=="band"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Network","profile","network",$funame,NULL,($curr=="net"?"active":NULL)); ?></li>        
        <?php if(!$this->foreign): ?>
        <li class="sep"></li>
        <li><?php ActionLink::create("Settings","profile","settings",NULL,NULL,($curr=="set"?"active":NULL)); ?></li>
        <?php endif; ?>
    </ul>
</div>