<form method="POST" action="/create/new_process" onsubmit="return validate()">
    <input type="hidden" name="tag" value="<?php echo $_GET['tag'] ?>"><br>

    <input type="text" class="text" name="first_name" placeholder="First Name"><br>
    <input type="text" class="text" name="company" placeholder="Business Name (will be used in your account's url)"><br>
    <input type="text" class="text" name="email" placeholder="Email"><br>
    <input type="submit" class="text submit" value="SIGN UP"><br>

    <input type="checkbox" name="terms" id="terms"> <small>By signing up, you agree to our <br><a target="_BLANK" href="https://membervault.co/terms">Terms</a> and <a target="_BLANK" href="https://membervault.co/privacy">Privacy Policy</a>.</small><br>
    <input type="checkbox" name="market" id="market"> <small>Yes, I want to receive your awesome emails about strategy, inspiration and other various tips & tricks for using my account.</small></i>

</form>
<div class="loading"></div>

<script>
    function validate(){
        if ( $('#terms').prop('checked') == true ) {
            $( '.loading' ).show();
            return true;
        } else {
            alert( 'You must agree to the terms to create an account.' );
            return false;
        }
    }
</script>
<!--PROOF PIXEL--><script src='https://cdn.useproof.com/proof.js?acc=25mmq26eqgQRjr0wr6aXdwz8znr2' async></script><!--END PROOF PIXEL-->