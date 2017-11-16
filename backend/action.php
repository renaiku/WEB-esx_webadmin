<?php

require("rcon.php");

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $user_id = $_GET['uid'];
    $server_id = $_GET['sid'];
}
        
// Check for action in url, imports the variables and do command.    
if($action == "kick") {
       
    foreach ($serverinfo as $server) {
        if($server['0'] == $server_id){
            
            $con = new q3query($server['2'], $server['3'], $success);

            if (!$success) {
                die ("blah");
            }
            
            $con->setRconpassword($server['4']);
            $con->rcon("clientkick $user_id $kickmessage");
            echo "You successfully should have kicked the user with ID $user_id. Redirect after 3 seconds.";
            header( "refresh:3;url=index.php" );
            die();
        }        
    }
}

?>