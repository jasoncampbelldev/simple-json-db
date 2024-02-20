<?php session_start(); // start session for session vars ?>

<html>
<body>


<?php 
	include 'json_db.php';
?>


<?php 
	// CSRF token to prevent cross-site request forgery
	$csrf_token_valid = false;
	if ($_POST['token'] && $_POST['token'] == $_SESSION['token']) {
		$csrf_token_valid = true;
	} else {
		if ($_POST['token']) {
			echo '<p><strong style="color: darkred;">CSRF token expired. Refresh page and try again.</strong></p>';
		} else {
			$_SESSION['token'] = md5(uniqid(mt_rand(), true));
		}
	}
?>

<h1>Simple JSON DB Test Page</h1>

<hr />


<h2>setRow</h2>

<form method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
	<input type="hidden" name="setRow" value="true" />
	<input type="text" name="name" placeholder="name" />
	<input type="text" name="message" placeholder="message" />
	<button type="submit" value="submit">
		Submit
	</button>
</form>

<?php
	if ($_POST['setRow'] && $csrf_token_valid) {
		$dataArray = array();
		$dataArray['name'] = $_POST['name'];
		$dataArray['message'] = $_POST['message'];
		$result = setRow("testFile", $dataArray);
		if ($result['status']) {
			echo "New Row ID: " . $result['data'];
		}
	}
?>


<hr />


<h2>updateRow</h2>

<form method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
	<input type="hidden" name="updateRow" value="true" />
	<input type="text" name="id" placeholder="id" />
	<input type="text" name="name" placeholder="name" />
	<input type="text" name="message" placeholder="message" />
	<button type="submit" value="submit">
		Submit
	</button>
</form>

<?php
	if ($_POST['updateRow'] && $csrf_token_valid) {
		$dataArray = array();
		$dataArray['name'] = $_POST['name'];
		$dataArray['message'] = $_POST['message'];
		$result = updateRow("testFile", $_POST['id'], $dataArray);
		if ($result['status']) {
			echo "Updated Row: " . $result['data'];
		}
	}
?>

<hr />


<h2>getRow</h2>

<form method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
	<input type="hidden" name="getRow" value="true" />
	<input type="text" name="id" placeholder="id" />
	<button type="submit" value="submit">
		Submit
	</button>
</form>

<?php
	if ($_POST['getRow'] && $csrf_token_valid) {
		$result = getRow("testFile", $_POST['id']);
		if ($result['status']) {
		    echo "id: " . $result['data']['id'] . "<br>";
		    echo "<strong>Properties</strong><br>";
			echo "name: " . $result['data']['name'] . "<br>";
			echo "message: " . $result['data']['message'] . "<br><br>";
		} else {
			echo "no results";
		}
	}
?>


<hr />


<h2>deleteRow</h2>

<form method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
	<input type="hidden" name="deleteRow" value="true" />
	<input type="text" name="id" placeholder="id" />
	<button type="submit" value="submit">
		Submit
	</button>
</form>

<?php
	if ($_POST['deleteRow'] && $csrf_token_valid) {
		$result = deleteRow("testFile", $_POST['id']);
		if ($result['status']) {
			echo "row deleted";
		} else {
			echo "error";
		}
	}
?>


<hr />


<h2>queryDB</h2>

<form method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
	<input type="hidden" name="queryDB" value="true" />
	<input type="text" name="propName" placeholder="Property Name" />
	<input type="text" name="propValue" placeholder="Property Value" />
	<button type="submit" value="submit">
		Submit
	</button>
</form>

<?php
	if ($_POST['queryDB'] && $csrf_token_valid) {
		$result = queryDB("testFile", $_POST['propName'], $_POST['propValue']);
		if ($result['status']) {
			foreach ($result['data'] as $key=>$row) {
			    echo "id: " . $key . "<br>";
			    echo "<strong>Properties</strong><br>";
				echo "name: " . $row['name'] . "<br>";
				echo "message: " . $row['message'] . "<br><br>";
			}
		} else {
			echo "no results";
		}
	}
?>

<hr />



<h2>getAllRows</h2>


<?php
	$result = getAllRows("testFile");
	if ($result['status']) {
		foreach ($result['data'] as $key=>$row) {
		    echo "id: " . $key . "<br>";
		    echo "<strong>Properties</strong><br>";
			echo "name: " . $row['name'] . "<br>";
			echo "message: " . $row['message'] . "<br><br>";
		}
	} else {
		echo "no results";
	}
?>

<button onClick="window.location = window.location.href;">Refresh</button>

<br /><br />

<hr />

<br /><br />

<a href="json/testFile.json" target="_blank">View JSON File</a>

<br /><br />

</body>
</html>