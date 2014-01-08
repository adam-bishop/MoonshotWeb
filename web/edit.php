<?php
require_once("./includes/db.php");
include_once("./includes/templates/header.html");

if(!isset($_GET['class']) || ($_GET['class'] != 'attribute' 
	&& $_GET['class'] != 'identity') || !isset($_GET['id'])) {
	echo('<h1>Error</h1>');
	echo('<span class="h1sub">You seem to have reached this page without the 
		correct parameters. Please return using the menu above.');
	echo $_GET['class'];
} else {
	switch($_GET['class']) {
		case 'identity' : 
			if (!isset($_GET['edit'])) { /* Show the form */
				echo('<h1>Edit Identity</h1>');
				$identityResult = $db->query("SELECT * FROM attributes WHERE id =
					" . $_GET['id']);
				if(!$identityResult) {
					die('There was an error running the query : ' . $db->error);
				} else {
					echo('<form action="./edit.php?class=identity&id=' . 
						$_GET['id'] . '&edit=true" method="post">');
					while($row = $identityResult->fetch_assoc()) {
						foreach($row as $col => $val) {
							if($col !== 'id') {
								echo('<label>' . $col . '</label>');
								echo('<input type="text" name="' . $col . 
									'" value="' . $val . '"><br>');
							} 
						}
					}
					echo('<input type="submit"></form>');
				}
			} else { /* Update the record in the db */
				$count = 0;
				$numItems = count($_POST);
				
				$query = "UPDATE " . $config['db']['tablename'] . " SET ";
				foreach($_POST as $key => $val) {
					if (++$i === $numItems) { //If last index, don't add comma
						$query .= $key . " = '" . $val . "'";
					} else {
						$query .= $key . " = '" . $val . "', ";
					}
				}
				$query .= "WHERE id = " . $_GET['id'];

				$updateIdentity = $db->query($query);

				if(!$updateIdentity) {
					die("There was an error with the update query : " . 
						$db->error);
				} else {
					echo('<h1>Updated identity attributes</h1>');
					echo('<span class="h1sub">The attributes for identity ' . 
						$_POST['identity'] . ' have been updated.</span>');
				}
			}

		break;
	}
}

include_once("./includes/templates/footer.html");