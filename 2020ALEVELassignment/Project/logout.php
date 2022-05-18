<?php

$_SESSION["employeeID"] = $_POST["employeeID"];
setcookie("employeeIDCookie", $employeeID, time() + (1), "/");
header("Location: /index.php");

?>