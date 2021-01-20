<style>
    table{
        border: 1px solid #000;
        width: 100%;
        text-align: left;
        border-collapse:collapse;
    }
        table td, table th{
            padding:5px;
            border: 1px solid #000;
        }
</style>

<table>
    <tr>
        <th>Rank</th>
        <th>EP</th>
        <th>Account</th>
    </tr>
<?php
    $l_nNumber = 1;
    foreach( $l_axUsers as $l_xUser ){
        echo "<tr>";
            echo "<td>#" . number_format( $l_nNumber ) . "</td>";
            echo "<td>" . number_format( $l_xUser['ep'] ) . "</td>";
            echo '<td><a href="https://' . $l_xUser['subdomain'] . '.vipmembervault.com/products" target="_BLANK" style="color:inherit">' . $l_xUser['subdomain'] . '</a></td>';
        echo "</tr>";
        $l_nNumber++;
    }
?>
</table>