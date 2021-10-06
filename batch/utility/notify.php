<?php


/**
 * This is the working function.
 * It just appends the message to a log file.
 * If the file does not exist, then it creates it.
 */
function notify($to_address, $subject, $message, $from) {
    $ts = date("Y-m-d H:i:s"); 
    $fp = fopen('/var/log/opp_scripts.log', 'a+');
    fwrite($fp, "$ts - $subject - $message");
    fclose($fp);
}    
?>
