<?php $concert = $this->concert[0]; ?>
<div class="content">
    <?php ActionLink::create("&#8592; View All Concerts","concert",NULL,NULL,NULL,"link clear-both"); ?>
    <div class="left">
        <div class="icon"></div>
        <div class="stamp">
            Created by
            <?php
                ActionLink::create(trim($concert["fname"]) == "" ? $concert["username"] : $concert["fname"], "profile", "of", $concert["username"], NULL, "link");
            ?>
            on <?php echo Format::prettyDateTime($concert["created"]); ?>
        </div>
        <div class="title"><?php echo $concert["cname"]; ?></div>
        <?php if($concert["approved"] == 0): ?><div class="approve">Not Yet Approved</div>
        <?php else: ?><div class="approve yes">Approved</div><?php endif; ?>
        <div class="label band"><?php ActionLink::create($concert["bname"],"band","view",$concert["bandid"],NULL,"link") ?></div>
        <div class="label date"><?php echo Format::prettyDate($concert["ctime"]); ?></div>
        <div class="label time"><?php echo Format::prettyTime($concert["ctime"]); ?></div>
        <div class="label venue"><?php echo $concert["venuename"]; ?></div>

        <?php if($concert["ticket"] != NULL) { ?><div class="label ticket">$ <?php echo $concert["ticket"]; ?></div><?php } ?>
        <?php if($concert["url"] != NULL) { ?>
        <div class="label url">
            <?php ActionLink::external($concert["url"],$concert["url"],"link"); ?>
        </div>
        <?php } ?>

        <div class="rating"></div>        
        <div class="options" data-cid="<?php echo $concert["cid"] ?>">
            <?php if($this->isConcertOwner): ?>
            <div>
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            </div>
            <?php endif; ?>
            <button class="recommend">Recommend</button>
            <?php if($this->lists != NULL) { ?><button class="addlist">Add to your List</button><?php } ?>
            <?php
                switch($this->attend) {
                case 0: break;
                case 1:
            ?><button data-mode="<?php echo $this->attend; ?>" class="attend">Attend</button><?php
                break;
                case 2:
            ?><button data-mode="<?php echo $this->attend; ?>" class="attend yes">Attending</button><?php
                break;
                case 3:
            ?><button data-mode="<?php echo $this->attend; ?>" class="attend no">Mark Attended</button><?php
                break;
                case 4:
            ?><button data-mode="<?php echo $this->attend; ?>" class="attend done">Mark Not Attended</button><?php
                    break;
                } 
            ?>
            <?php if($this->isApprove): ?>
            <button class="appr">Approve</button>
            <?php endif; ?>
        </div>
        <?php if($this->genres != NULL): ?>
        <div class="genres">
            <?php
                foreach($this->genres as $genre)
                    ActionLink::create($genre["subcatname"],"concert",NULL,NULL,["genre" => $genre["subcatid"]]);
            ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="right"><?php $nothing = TRUE; $rating = 0; ?>
        <div class="block newpost no-focus">
            <form class="review">
                <input type="hidden" class="id" value="<?php echo $concert["cid"]; ?>">
                <input type="text" class="txt" placeholder="Write a new Review">
                <div class="left">
                    <span class="rating" data-disabled="false"></span>
                </div>
                <div class="right">
                    <input type="reset" value="Cancel" class="link">
                    <input type="submit" class="btn" value="Post">
                </div>
            </form>
        </div>
        <?php foreach($this->reviews as $rev): $nothing = FALSE; ?>
        <div class="block post">
            <div class="stamp">on <?php echo Format::prettyDateTime($rev["reviewdate"]); ?></div>
            <div class="text"><?php echo $rev["review"]; ?></div>
            <div class="rating" data-rate="<?php echo $rev["rating"]; ?>"></div>
            <?php $rating += $rev["rating"]; ?>
        </div>
        <?php endforeach; ?>

        <?php if($nothing): ?>
        <div class="section-title empty">Sorry, there are no reviews to display.</div>
        <?php endif; ?>
    </div>
</div>
<div id="edit-concert" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form">
                <form class="concert form1">
                    <div class="row row1">
                        <input type="hidden" class="cid" value="<?php echo $concert["cid"]; ?>" name="cid">
                        <input type="text" placeholder="Concert Name" class="txt cname" name="cname" value="<?php echo $concert["cname"]; ?>">
                    </div>
                    <div class="row row2">
                        <label>Band:</label>
                        <select class="txt bandid" name="bandid">
                            <option></option>
                            <?php foreach($this->bands as $band): ?>
                            <option value="<?php echo $band["bandid"]; ?>" <?php echo $band["bandid"] == $concert["bandid"] ? "selected" : ""; ?>>
                                <?php echo $band["bname"]; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label>Venue:</label>
                        <select class="txt venueid" name="venueid">
                            <option></option>
                            <?php print_r($this->venues); ?>
                            <?php foreach($this->venues as $venue): ?>
                            <option value="<?php echo $venue["venueid"]; ?>" <?php echo $venue["venueid"] == $concert["venueid"] ? "selected" : ""; ?>>
                                <?php echo $venue["venuename"]; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row row3">
                        <label>Date:</label><input type="date" class="txt ctime1" name="ctime1" value="<?php echo Format::stdDate($concert["ctime"]); ?>">
                        <label>Time:</label><input type="time" class="txt ctime2" name="ctime2" value="<?php echo Format::stdTime($concert["ctime"]); ?>">
                    </div>
                    <div class="row row4">
                        <input type="number" min="0" class="txt ticket" placeholder="Ticket Price" name="ticket" value="<?php echo $concert["ticket"]; ?>">
                        <input type="text" class="txt url" placeholder="Url" name="url" value="<?php echo $concert["url"]; ?>">
                    </div>
                    <div class="row row5">
                        <input type="button" value="Cancel" class="link cancel">
                        <input type="submit" value="Save" class="btn next">
                    </div>
                </form>
                <form class="concertgenre form2">
                    <input type="text" placeholder="Start typing to find available genres" class="txt genre">
                    <input type="submit" style="display: none">
                    <div class="genre-wrap">
                        <div class="genres">
                            <?php foreach($this->genres as $entry): ?>
                            <div class="genre" title="Click to remove" data-id="<?php echo $entry["subcatid"]; ?>">
                                <?php echo $entry["subcatname"]; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
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
<?php if($this->lists != NULL): ?>
<div id="add-list" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form add list">
                <form class="userlist">
                    <input type="hidden" class="cid" value="<?php echo $concert["cid"]; ?>" name="cid">
                    <select class="txt listid">
                        <option></option>
                        <?php foreach($this->lists as $list): ?>
                        <option value="<?php echo $list["listid"]; ?>"><?php echo $list["listname"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="status"></div>
                    <input type="button" value="Cancel" class="link cancel">
                    <input type="submit" value="Add" class="btn next">
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    $(function () { $(".content > .left .rating").ratingAttr(Math.round(<?php echo $nothing ? 0 : $rating / sizeof($this->reviews); ?>)); });
</script>