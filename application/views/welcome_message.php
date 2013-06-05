<style type="text/css">
    .form-signin {
        max-width: 350px;
        padding: 40px 29px 29px;
        margin: 0 auto 20px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"]{
        font-size: 16px;
        height: auto;
        margin-bottom: 5px;
        padding: 7px 9px;
        width: 84%;
        display: inline-block;
    }
    .add-on{
        padding: 7px 9px !important;
    }
    .input-prepend{
        width: 100%;
    }
    #form-logo{
        width: 15%;
        margin: auto;
        margin-bottom: -55px;
    } 
</style>
<div class="container">
    <div id="form-logo"><img src="images/logo.png" /></div>
    <form class="form-signin transparent-box" method="POST">
        <h2 class="form-signin-heading">Login to your Account</h2>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span>
            <input type="text" class="input-xlarge" placeholder="Username" name="username" required autofocus />
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span>
            <input type="password" class="input-xlarge" placeholder="Password" name="password" required />
        </div>
        <?php
        if ($error == 1) {
            echo "<div class='alert alert-error'>Invalid Username or Password!</div>";
        }
        ?>
        <button class="btn btn-large btn-primary" type="submit">Sign in &raquo;</button>
        <a href=""><h6 class="pull-right">Forgot Password?</h6></a>
    </form>

</div>
