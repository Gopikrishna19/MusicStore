<div class="leftpanel">
    <ul>
        <li><?php ActionLink::create("News","profile",NULL,NULL,NULL,($curr=="news"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("My Posts","profile","posts",NULL,NULL,($curr=="post"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("My Reviews","profile","reviews",NULL,NULL,($curr=="rev"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Upcoming Concerts","profile","concerts",NULL,NULL,($curr=="con"?"active":NULL)); ?></li>
        <li><?php ActionLink::create("Followers & Following","profile","follow",NULL,NULL,($curr=="fol"?"active":NULL)); ?></li>
        <li class="sep"></li>
        <li><?php ActionLink::create("Settings","profile","settings",NULL,NULL,($curr=="set"?"active":NULL)); ?></li>        
    </ul>
</div>