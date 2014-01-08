<?php
require('./includes/config.php');

$db = new mysqli($config['db']['hostname'], $config['db']['user'], 
	$config['db']['pass'], $config['db']['dbname']);

if($db->connect_errno > 0){
	die('Unable to connect to the database');
}