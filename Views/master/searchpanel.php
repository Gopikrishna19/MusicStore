<div class="leftpanel">
    <ul>
        <li><?php ActionLink::create("Recommended","search",NULL,NULL,NULL,($curr=="rec"?"active":NULL)); ?></li>
        <li>
            <?php ActionLink::create("Search Concerts","search","concert",NULL,NULL,($curr=="con"?"active":NULL)); ?>
            <form>
                <input type="hidden" value="<?php echo $this->key; ?>" name="key">
                <label>Date: </label><input type="date" class="txt" name="date" value="<?php echo $this->date; ?>">
                <label>Creator: </label><input type="text" class="txt" name="creator" value="<?php echo $this->creator; ?>" autocomplete="off">
                <label>Genre: </label>
                <select class="txt" name="genre">
                    <option></option>
                    <?php foreach($this->genres as $genre): ?>
                    <option value="<?php echo $genre["catid"]; ?>" <?php echo $this->genre == $genre["catid"] ? "selected" : ""; ?>>
                        <?php echo $genre["catname"]; ?>
                    </option>
                    <?php endforeach; ?>
                </select>                
                <input type="submit" value="Filter" class="btn">
            </form>
        </li>
        <li>
            <?php ActionLink::create("Search Bands","search","band",NULL,NULL,($curr=="band"?"active":NULL)); ?>
            <form>
                <input type="hidden" value="<?php echo $this->key; ?>" name="key">
                <label>Genre: </label>
                <select class="txt" name="genre">
                    <option></option>
                    <?php foreach($this->genres as $genre): ?>
                    <option value="<?php echo $genre["catid"]; ?>" <?php echo $this->genre == $genre["catid"] ? "selected" : ""; ?>>
                        <?php echo $genre["catname"]; ?>
                    </option>
                    <?php endforeach; ?>
                </select>                
                <input type="submit" value="Filter" class="btn">
            </form>
        </li>
        <li><?php ActionLink::create("Search People","search","people",NULL,NULL,($curr=="peop"?"active":NULL)); ?></li>
    </ul>
</div>