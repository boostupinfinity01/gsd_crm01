<?php

include('connection.php');
removeSession("log_userid");
removeSession("log_username");
removeSession("log_usertype");
session_destroy();

header('location: pages-login.php');

?>