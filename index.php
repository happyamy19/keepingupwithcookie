<html>
<head>
	<title>Keeping Up With Cookie</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Keeping Up With Cookie</h1>
	
	<div id="form">
	<h2>Login</h2>
	
	<form method="post" action="login.php">
		<p>Use your special username and password given <br>to you by Amy to make Cookie updates!</p>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username"><br><br>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password"><br><br>
		<input type="submit" value="Login">
	</form>
	</div>
	
	<?php
		// Connect to the database

		//function to format dates from the database
		function formatDate($input) {
			$timestamp = strtotime($input);
			$formatted_date = date("F j, Y", $timestamp);
			return $formatted_date;
		}

		// connect to the database
		$servername = "104.168.151.223";
		$username = "gxurfqfx_amy";
		$password = "DeWdwAV4Ty4gatT";
		$dbname = "gxurfqfx_cookie";
		$db = mysqli_connect($servername, $username, $password, $dbname);

		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		// Check if the form has been submitted
		if(isset($_POST['submit'])) {
			// Get the form data
			$title = $_POST['title'];
			$body = $_POST['body'];
			
			// Insert the data into the database
			$query = "INSERT INTO posts (title, body) VALUES ('$title', '$body')";
			mysqli_query($db, $query);
		}
		
		// Retrieve the updates from the database
		$query = "SELECT * FROM posts ORDER BY id DESC";
		$result = mysqli_query($db, $query);
		
		// Display the updates
		while($row = mysqli_fetch_assoc($result)) {
			echo "<div id='post'>";
			echo "<h2>" . formatDate($row['date']) . ": " . $row['title'] . "</h2>";
			echo "<p>" . $row['body'] . "</p>";
			echo "</div>";
		}

		mysqli_close($db);
	?>

</body>
</html>