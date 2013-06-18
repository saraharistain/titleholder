<?php
 echo $header;
?>

<div id="div_main" style="background-image: url('<?php echo base_url('assets/images/splash.png'); ?>') !important;">
    <!-- login -->
    <div class="div_child">
        <button id="login_btn">LOGIN</button>
    </div>

    <!-- signup -->
    <div class="div_child">
        <button id="signup_btn">SIGN UP</button>
    </div>
</div>
</center>

<!-- login -->
<div id="login_div" class="modal hide fade" role="dialog">
    <form action="<?php echo site_url() . 'login' ?>" method="post" id="login">
        <br>
        <div class="modal-body">
            <div>
                <input type="text" name="email"  placeholder="email" />
            </div>
            <div>
                <input type="password" name="password" placeholder="password" />
            </div>
            <input type="submit" id="login-btn"  class="btn btn-primary" data-loading-text="Processing..." value="Login" autocomplete="off" />
            <!--<input type="submit" value="login">-->
            <div class="msgcontainer">
                <div id="msgc" class="alert  fade in ">

                    <span id="login_message"></span>
                    <a class="close" href="#">&times;</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function(){
        $('#login_btn').on("click", function(){
            $('#login_div   ').modal();
        });

        $('#signup_btn').click(function(){
            window.location = "<?php echo site_url('signup'); ?>";
        });
    });
</script>

</body>
</html>