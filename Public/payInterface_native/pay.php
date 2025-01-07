<?php
foreach($_POST as $temp){
$data .= $temp;
}
foreach($_GET as $temp){
$dat .= $temp;
}
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = $data;
fwrite($myfile, $txt);
$txt = $dat;
fwrite($myfile, $txt);
fclose($myfile);