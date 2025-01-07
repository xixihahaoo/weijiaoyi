<?php
require_once ("phpqrcode/phpqrcode.php");
error_reporting(E_ERROR);
$url = urldecode($_GET["data"]);
QRcode::png($url);
?>