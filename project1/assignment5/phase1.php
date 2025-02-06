<?php 
$path="/home/kewal/vs/text1.txt";
$file_name = basename($path);

$success = chgrp($$file_name,"bhupal");
var_dump($success);