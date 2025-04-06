<?php
     session_start();
     echo $_SESSION['id'];
     echo " | ";
     echo $_SESSION['username'];
     echo " | ";
     echo $_SESSION['userProfile'];
?>