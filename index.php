<?php 

require_once("include.php");

$root = new Usuario();
$root->getBYid(2);
echo $root;