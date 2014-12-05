<?php $curr="con"; require "Views/master/leftpanel.php"; $nothing = TRUE; ?>
<div class="content">
    <?php ActionLink::create("View All Concerts &#8594;","concert",NULL,NULL,NULL,"link clear-both"); ?>
    <?php if(!$this->foreign) { ?>
    <div class="section-title"><button class="edit concert">Click here to create a new concert</button></div>
    <?php } ?>
    <?php if($this->by != NULL): $nothing = FALSE; ?>
    <div class="section-title">Posted by Me</div>
    <div class="section by">
        <?php foreach($this->by as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">on <?php echo Format::prettyDateTime($entry["created"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->attending) && $this->attending != NULL): $nothing = FALSE; ?>
    <div class="section-title">I am Attending</div>
    <div class="section attin">
        <?php foreach($this->attending as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">Time: <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($this->attended) && $this->attended != NULL): $nothing = FALSE ?>
    <div class="section-title">I have Attended</div>
    <div class="section atted">
        <?php foreach($this->attended as $entry): ?>
        <a class="entry block concert" href="/concert/view/<?php echo $entry["cid"]; ?>">
            <div class="icon"></div>
            <div class="name"><?php echo $entry["cname"]; ?></div>
            <div class="stamp">Time: <?php echo Format::prettyDateTime($entry["ctime"]); ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($nothing): ?>
    <div class="section-title empty">Sorry, there are no concerts to display.</div>
    <div>Click "Search" to find new concerts</div>
    <?php endif; ?>
</div>
<div id="edit-concert" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form">
                <form class="concert form1">
                    <div class="row row1"><input type="text" placeholder="Concert Name" class="txt cname" name="cname"></div>
                    <div class="row row2">
                        <label>Band:</label>
                        <select class="txt bandid" name="bandid">
                            <option></option>
                            <?php foreach($this->bands as $band): ?>
                            <option value="<?php echo $band["bandid"]; ?>"><?php echo $band["bname"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>Venue:</label>
                        <select class="txt venueid" name="venueid">
                            <option></option>
                            <?php print_r($this->venues); ?>
                            <?php foreach($this->venues as $venue): ?>
                            <option value="<?php echo $venue["venueid"]; ?>"><?php echo $venue["venuename"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                    
                    <div class="row row3">
                        <label>Date:</label><input type="date" class="txt ctime1" name="ctime1">
                        <label>Time:</label><input type="time" class="txt ctime2" name="ctime2">
                    </div>
                    <div class="row row4">
                        <input type="number" min="0" class="txt ticket" placeholder="Ticket Price" name="ticket">
                        <input type="text" class="txt url" placeholder="Url" name="url">
                    </div>
                    <div class="row row5">
                        <input type="button" value="Cancel" class="link cancel">
                        <input type="submit" value="Create" class="btn next">
                    </div>
                </form>
                <form class="concertgenre form2">
                    <input type="text" placeholder="Start typing to find available genres" class="txt genre">
                    <input type="submit" style="display: none">
                    <div class="genre-wrap">
                        <div class="genres"></div>
                    </div>
                    <div class="controls">
                        <button class="btn done" type="button">Done</button>
                    </div>
                    <ul class="datalist">
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>