<div class="center-it wrapper">
    <div class="left column">
        <span style="font-size: 125%">Welcome to Music Share!</span><br>
        Connect and share your beats with your friends.
    </div>
    <div class="right column">
        <div style="font-size: 125%">Register ...</div>
        <form class="register">
            <input type="text" placeholder="Choose a username" class="txt uname">
            <input type="password" placeholder="Choose a password" class="txt upass">
            <input type="password" placeholder="Confirm password" class="txt cpass">
            <div class="loader"></div>
            <input type="submit" value="Go!" class="btn">
            <?php ActionLink::create("Log In","home",NULL,NULL,NULL,"link"); ?>
        </form>
        <p class="error ulent">
            * Username should be at least 6 characters long.
        </p>
        <p class="error uname">
            * An user with the username already exists. Please try another username.
        </p>
        <p class="error upass">
            * Your password should contain at least 6 characters including at least one capital, one small and one numerical values.
        </p>
        <p class="error cpass">
            * Your passwords do not match.
        </p>
    </div>
</div>