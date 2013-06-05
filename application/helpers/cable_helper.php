<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_functions
 *
 * @author Bk Santiago 
 */
//TIMEZONE
date_default_timezone_set('Asia/Manila');

function sendHome() {
    header("Location: " . base_url());
}

function msgRedirect($msg, $url){
    echo "<script>alert('$msg');</script>";
    echo "<meta http-equiv='Refresh' content='0; URL=$url'>";
}
?>
