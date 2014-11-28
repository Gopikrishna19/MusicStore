<div class="leftpanel">
    <?php if(isset($this->foreign)): ?>
    <ul>        
        <li><?php ActionLink::create("Posts","profile","posts",$this->foreignUN,NULL,($curr=="post"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Reviews","profile","reviews",$this->foreignUN,NULL,($curr=="rev"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Concerts","profile","concerts",$this->foreignUN,NULL,($curr=="con"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Bands","profile","bands",$this->foreignUN,NULL,($curr=="band"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Network","profile","network",$this->foreignUN,NULL,($curr=="net"?"active":NULL)); ?></li>        
    </ul>
    <?php else: ?>
    <ul>
        <li><?php ActionLink::create("News","profile",NULL,NULL,NULL,($curr=="news"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Posts","profile","posts",NULL,NULL,($curr=="post"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Reviews","profile","reviews",NULL,NULL,($curr=="rev"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Concerts","profile","concerts",NULL,NULL,($curr=="con"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Bands","profile","bands",NULL,NULL,($curr=="band"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Network","profile","network",NULL,NULL,($curr=="net"?"active":NULL)); ?></li>
        <li class="sep"></li>
        <li><?php ActionLink::create("Settings","profile","settings",NULL,NULL,($curr=="set"?"active":NULL)); ?></li>        
    </ul>
    <?php endif; ?>
</div>