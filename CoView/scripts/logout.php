<?php
session_start();
header("Access-Control-Allow-Origin: *");
session_destroy();
header("Location:http://localhost/CoView");
 ?>
