<?php $curr="list"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php if(!$this->foreign) { ?>
    <div class="section-title"><button class="edit list">Click here to create a new list</button></div>
    <?php } ?>

    <?php if($this->lists != NULL): $nothing = FALSE; ?>
    <div class="section-title">Posted by Me</div>
    <div class="section list">
        <?php foreach($this->lists as $entry): ?>
        <a class="entry block list" href="/profile/viewlist/<?php echo $funame."/".$entry["listid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["listname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["listdate"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no lists to display.</div>
    <?php endif; ?>
</div>
<div id="edit-list" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form list">
                <form class="userlist">
                    <input type="text" class="txt listname" placeholder="List Name">
                    <p>After creating the list, go to a concert and click "Add to your list".</p>
                    <input type="button" class="link cancel" value="Cancel">
                    <input type="submit" class="btn" value="Create">
                </form>
            </div>
        </div>
    </div>
</div>