<?php
require_once("./includes/db.php");
include_once("./includes/templates/header.html");

if(!isset($_GET['class']) || ($_GET['class'] != 'attribute' 
	&& $_GET['class'] != 'identity')) {
	echo('<h1>Error</h1>');
	echo('<span class="h1sub">You seem to have reached this page without the 
		correct parameters. Please return using the menu above.');
	echo $_GET['class'];
} else {

	switch($_GET['class']) {
		case 'identity' :
		echo('<h1>Manage Identities</h1>');
		echo('<span class="h1sub">This page displays all the identities currently 
			stored on this attribute provider. Identities can be removed using this 
			page, or their attributes can be changed using the edit command.</span>');

		/* Display the table of identities with edit and delete buttons */
		$identityResult = $db->query("SELECT id, identity FROM attributes");
		if(!$identityResult) {
			die('There was an error running the query : ' . $db->error);
		} else {
			echo('<div class="identityTable">');
			while($row = $identityResult->fetch_assoc()) {
				echo '<div class="identityName">' . $row['identity'] . 
				'</div>' .	'<div class="identityButton">
				<a href="./edit.php?class=identity&id=' . $row['id'] . 
				'">Edit</a></div><div class="identityButton">
				<a href="./delete.php?class=identity&id=' . $row['id'] . 
				'">Delete</a></div><br>';
			}
			echo("</div>");
		}

		break;
		case 'attribute' :
		echo('<h1>Manage Attributes</h1>');
		echo('<span class="h1sub">This page displays the available attributes, 
			their data types, descriptions, and default values. Attributes can 
			be edited and deleted from here.</span>');
		$attributeResult = $db->query("SELECT COLUMN_NAME, DATA_TYPE, 
			COLUMN_COMMENT FROM information_schema.columns WHERE table_name 
			= '" . $config['db']['tablename'] . "'");
		if(!$attributeResult) {
			die('There was an error running the query : ' . $db->error);
		} else {
			echo('<div class="attributeTable">');
			while($row = $attributeResult->fetch_assoc()) {
				echo '<div class="attributeName">' . $row['COLUMN_NAME'] . 
				'</div><div class="attributeType">' . $row['DATA_TYPE'] . 
				'</div><div class="attributeDesc">' . $row['COLUMN_COMMENT'] . 
				'</div><div class="attributeButton">
				<a href="./delete.php?class=attribute&id=' . 
				$row['COLUMN_NAME'] . '">Delete</a></div>';
			}
			echo("</div>");
		}
		break;
	}
}

include_once("./includes/templates/footer.html");