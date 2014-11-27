<?php $curr="post"; require "Views/master/leftpanel.php"; ?>
<div class="content">
    <div class="block newpost no-focus">
        <form class="post">
            <input type="text" class="txt" placeholder="Write a new Post">
            <div class="left">
                <div class="visi pri" data-val="0" title="For only me"></div>
                <div class="visi fol" data-val="1" title="For my followers"></div>
                <div class="visi pub active" data-val="2" title="For public"></div>
            </div>
            <div class="right">
                <input type="submit" class="btn" value="Post">
            </div>
        </form>
    </div>    
    <?php foreach($this->posts as $row => $post): ?>
    <div class="block post">
        <div class="post-stamp">on <?php echo $post["postdate"]; ?></div>
        <div class="post-content"><?php echo $post["text"]; ?></div>
    </div>
    <?php endforeach; ?>
</div>