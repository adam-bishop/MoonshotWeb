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
		if(!isset($_GET['create'])) { //Show the add form
			include_once("./includes/templates/add_identity_form.html");
		} else { //Validate input and provide feedback

			$identityStatement = $db->prepare("INSERT INTO attributes 
				(identity) VALUES (?)");
			$rc = $identityStatement->bind_param('s', $_POST['identity']);
			$identityStatement->execute();
			echo $identityStatement->error;
			$identityStatement->close();
		}

		break;
		case 'attribute' :
		if(!isset($_GET['create'])) { //Show the add form
			include_once("./includes/templates/add_attribute_form.html");
		} else { //Validate input and provide feedback
			$errors = array();
			$name = trim($_POST['name']); //Remove starting and ending white space
			$description = trim($_POST['description']); //Remove starting and ending white space
			if (preg_match('/\s/',$name)) { //If there is any white space
				$errors[] = "The name of the attribute cannot contain white space";
			}

			//Get the MySQL data type to use
			switch($_POST['type']) {
				case 'int' : $type = "INT"; break;
				case 'varchar' : $type = "VARCHAR(255)"; break;
				default : $errors[] = "Invalid type for the attribute";
			}

			if (empty($errors)) { //If there are no errors, carry out the alter query
				$query = "ALTER TABLE " . $config['db']['tablename'] . 
				" ADD " . $name . " " . $type . " DEFAULT '" .
				$_POST['default'] . "' COMMENT '" . $description . "'";

				$attributeStatement = $db->query($query);
				if(!$attributeStatement) {
					die('There was an error running the query : ' . $db->error);
				} else {
					echo('<h1>Added Attribute</h1>');
					echo('<span class="h1sub">Successfully added the attribute ' . 
						$_POST['name'] . '.</span>');
				}
			} else {
				echo('<h1>Error</h1>');
				echo('<p>');
				foreach($errors as $err) {
					echo($err . '<br>');
				}
				echo('</p>');
			}
		}
		break;
	}
}

include_once("./includes/templates/footer.html");
