<?php
require_once("./includes/db.php");
include_once("./includes/templates/header.html");

if (!isset($_GET['id'])) { //If no id param was passed
	echo('<span class="h1sub">You seem to have reached this page in an error 
		as no identitiy parameter has been passed. Please return using the 
		navigation menu above.</span>');
} else {
	switch($_GET['class']) {
		case 'identity' :
		echo('<h1>Delete an Identity</h1>'); //Show the title
		if(!isset($_GET['delete'])) {
			$result = $db->query("SELECT * FROM attributes WHERE id = " . 
				$_GET['id']);
			while($row = $result->fetch_assoc()) {
				echo('<span class="h1sub">Are you sure you want to delete 
					user '. $row['identity'] . '? Scroll to the bottom of the 
					page to confirm the deletion.</span>');
				echo('<p>Identity Attributes:<br>');
				/* Show the user attributes */
				foreach($row as $key=>$value) {
					echo($key . ' = ' . $value . '<br>');
				}
				/* Show the confirm delete link */
				echo('</p><br><p><a href="./delete.php?class=identity&id=' . 
					$_GET['id'] . '&delete=true">Delete Identity</a></p>');
			}
		} else { //Execute the delete query
			$deleteStatement = $db->prepare("DELETE FROM attributes WHERE 
				id = ?");
			echo $deleteStatement->error;
			$deleteStatement->bind_param('i', $_GET['id']);
			echo $deleteStatement->error;
			$deleteStatement->execute();
			echo $deleteStatement->error;
			$deleteStatement->close();
			echo('<span class="h1sub">The identitiy has ben deleted.</span>');
		}

		break;
		case 'attribute' : 
		//Execute the delete query
		$deleteStatement = $db->query("ALTER TABLE " . $config['db']['tablename'] .
			" DROP COLUMN `" . $_GET['id'] . "`;");
		if(!$deleteStatement) {
			die('There was an error running the query : ' . $db->error);
		} else {
			echo('<h1>Deleted Attribute</h1>');
			echo('<span class="h1sub">Successfully deleted the attribute ' . 
				$_GET['id'] . '.</span>');
		}
		
		break;
	}
}

include_once("./includes/templates/footer.html");