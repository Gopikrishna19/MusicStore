<?php $curr="set"; require "Views/master/leftpanel.php"; $user = $this->user[0]; ?>
<div class="content settings">
    <div class="section-title"><button class="edit taste">Click here to edit your music tastes</button></div>
    <div class="section-title">Change Password</div>
    <form class="password section">
        <div><input type="password" placeholder="New Password" class="txt upass"></div>
        <p class="error upass">Password should contain at least 6 characters including at least one capital, one small and one numerical values.</p>
        <div><input type="password" placeholder="Confirm Password" class="txt cpass"></div>
        <p class="error cpass">Passwords do not match.</p>
        <div><input type="submit" class="btn" value="Save"><i class="status"></i></div>
    </form>
    <div class="section-title">Personal Details</div>
    <form class="details section">
        <div><span>First Name:</span><input type="text" name="fname" class="txt" value="<?php echo $user["fname"]; ?>"></div>
        <div><span>Last Name:</span><input type="text" name="lname" class="txt" value="<?php echo $user["lname"]; ?>"></div>
        <div><span>City:</span><input type="text" name="city" class="txt" value="<?php echo $user["city"]; ?>"></div>
        <div><span>&nbsp;</span><input type="submit" class="btn" value="Save"><i class="status"></i></div>
    </form>
</div>
<div id="edit-taste" class="edit-diag">
    <div class="table">
        <div class="cell">
            <div class="form">
                <form class="usergenre">
                    <input type="text" placeholder="Start typing to find available genres" class="txt genre">
                    <input type="submit" style="display: none">
                    <div class="genre-wrap">
                        <div class="genres">
                            <?php foreach($this->taste as $entry): ?>
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