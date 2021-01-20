<p>Help Us, Help You</p>
<form method="POST" action="/create/new_process_2/<?php echo $l_xUser['id'] ?>/?status=<?php echo $l_sStatus ?>" onsubmit="return validate()">

    <select class="text" name="email_service" id="email_service">
        <option value="">- Select Your Email Service -</option>
        <option value="Active Campaign">Active Campaign</option>
        <option value="ConvertKit">ConvertKit</option>
        <option value="Drip">Drip</option>
        <option value="Mailchimp">Mailchimp</option>
        <option value="Mailerlite">Mailerlite</option>
        <option value="Aweber">Aweber</option>
        <option value="Ontraport">Ontraport</option>
        <option value="Infusionsoft">Infusionsoft</option>
        <option value="Constant Contact">Constant Contact</option>
        <option value="GetResponse">GetResponse</option>
        <option value="Other">Other</option>
    </select>
    
    <br>
    <select class="text" name="sales_source" id="sales_source">
        <option value="">- What's your primary source of sales currently? -</option>
        <option value="1:1 services">1:1 services</option>
        <option value="Courses">Courses</option>
        <option value="Membership">Membership</option>
        <option value="Other">Other</option>
    </select>
    
    <br>

    <input type="submit" class="text submit" value="SUBMIT"><br>

</form>

<script>
    function validate(){
        if ( $('#email_service').val() == '' ) {
            alert( 'Please select an email service.' );
            return false;
        }else if ( $('#sales_source').val() == '' ) {
            alert( 'Please select your primary source of sales.' );
            return false;
        } else {
            return true;
        }
    }
</script>