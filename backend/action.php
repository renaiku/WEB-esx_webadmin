<?php

require("rcon.php");
include("../config/config.php");

$con = new q3query(GAME_SERVER_ADDRESS, GAME_SERVER_PORT, $success);

if (!$success) {
    die ("blah");
}

$con->setRconpassword(GAME_SERVER_RCON_PASSWORD);
        
  
if($_GET['action'] == "kick") {
    $con->rcon("clientkick " . $_GET['id'] . " " . $_GET['msg']);
    echo "You successfully should have kicked the user ". $_GET['id'] . ". Redirect after 3 seconds.";
}

if($_GET['action'] == "say") {
    $con->rcon("say " . $_GET['msg']);
    echo "You successfully sent a message to the in-game chat. Redirect after 3 seconds.";
}

if($_GET['action'] == "setjob") {
    $con->rcon("setjob " . $_GET['id'] . " " . $_GET['job'] . " " . $_GET['grade']);
    echo "You successfully changed a job. Redirect after 3 seconds.";
}

//header( "refresh:3;url=index.php" );
//die();

?>