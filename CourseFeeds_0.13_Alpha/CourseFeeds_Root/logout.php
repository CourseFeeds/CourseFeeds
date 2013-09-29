<?php
session_start();
//Destroy session
session_destroy();
//now destroy cookie
setcookie("user", "", time() - 1728000);
setcookie("pass", "", time() - 1728000);
header('Location: indexRefresh.html');
?>
