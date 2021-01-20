<?php
    if ( $l_xUser ) {
        echo "Account Found!<br><br>";
        echo '<a href="https://' . $l_xUser['subdomain'] . '.vipmembervault.com/admin" target="_BLANK">https://' . $l_xUser['subdomain'] . '.vipmembervault.com/admin</a><br>';
        echo 'Username: admin<br>';
        echo '(default password is "admin" until changed)<br><br>';
        echo '<a class="button" href="/create/lookup">Search Another Email</a><br>';
        echo '<a class="button" href="/create/new">Create a New Account</a><br>';

        //print_r( $l_xUser );
    } else {
        echo "No account found for that email address.<br><br>";
        echo '<a class="button" href="/create/lookup">Search Another Email</a><br>';
        echo '<a class="button" href="/create/new">Create a New Account</a><br>';
    }
?>