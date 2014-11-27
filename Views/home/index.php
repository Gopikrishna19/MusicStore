<div class="center-it wrapper">
    <div class="left column">
        <span style="font-size: 125%">Welcome to Music Share!</span><br>
        Connect and share your beats with your friends.
    </div>    
    <div class="right column">
        <div style="font-size: 125%">Sign In ...</div>
        <form class="login">
            <input type="text" placeholder="Username" class="txt uname">
            <input type="password" placeholder="Password" class="txt upass">
            <div class="loader"></div>
            <input type="submit" value="Go!" class="btn">
            <?php ActionLink::create("Register","home","register",NULL,NULL,"link"); ?>
            <?php ActionLink::create("Forgot Password","home","forgot",NULL,NULL,"link"); ?>
        </form>
        <p class="error invalid">
            * Invalid username and/or password.
        </p>
    </div>
</div>