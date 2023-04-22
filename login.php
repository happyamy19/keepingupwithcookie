<?php
session_start();

// connect to the database
$dbhost = '104.168.151.223';
$dbuser = 'gxurfqfx_amy';
$dbpass = 'DeWdwAV4Ty4gatT';
$dbname = 'gxurfqfx_cookie';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if(isset($_POST['submitpost'])) {
	// Get the form data
	$title = $_POST['title'];
	$body = $_POST['body'];
				
	// Insert the data into the database
	$query_submit = "INSERT INTO posts (title, body) VALUES ('$title', '$body')";
	mysqli_query($conn, $query_submit);
}

// function to formate dates from database
function formatDate($input) {
    $timestamp = strtotime($input);
    $formatted_date = date("F j, Y", $timestamp);
    return $formatted_date;
}

echo "<html>";
echo "<head>";
echo "<title>Keeping Up With Cookie</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";
echo "<h1>Keeping Up With Cookie</h1>";

// if the user has just logged in
if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "SELECT * FROM logins WHERE username='$username' AND password='$password'";
	$result = mysqli_query($conn, $query);

	// correct username and password
	if (mysqli_num_rows($result) == 1) {
		$_SESSION['username'] = $username;
		echo "<div id='post'>";
		echo "Hello, $username!";
		echo "<br><a href='index.php'>Logout</a>";
		echo "</div>";
		echo "<div id='form'>";
		echo "<h2>Add a New Update</h2>";
		echo "<form method='post' action='login.php'>";
		echo "<label>Title:</label><br>";
		echo "<input type='text' name='title' required><br>";
		echo "<label>Body:</label><br>";
		echo "<textarea name='body' required></textarea><br>";
		echo "<input type='submit' name='submitpost' value='Submit'>";
		echo "</form>";
		echo "</div>";
	} 
	
	// incorrect username and password
	else {
		echo "<div id='form'>";
		echo "Invalid username or password.";
		echo "<h2>Login</h2>";
		echo "<form method='post' action='login.php'>";
		echo "<label for='username'>Username: </label>";
		echo "<input type='text' id='username' name='username'><br><br>";
		echo "<label for='password'>Password: </label>";
		echo "<input type='password' id='password' name='password'><br><br>";
		echo "<input type='submit' value='Login'>";
		echo "</form>";
		echo "</div>";
	}

} else {
	$username = $_SESSION['username'];
	echo "<div id='post'>";
	echo "Hello, $username!";
	echo "<br><a href='index.php'>Logout</a>";
	echo "</div>";
	echo "<div id='form'>";
	echo "<h2>Add a New Update</h2>";
	echo "<form method='post' action='login.php'>";
	echo "<label>Title:</label><br>";
	echo "<input type='text' name='title' required><br>";
	echo "<label>Body:</label><br>";
	echo "<textarea name='body' required></textarea><br>";
	echo "<input type='submit' name='submitpost' value='Submit'>";
	echo "</form>";
	echo "</div>";

}

	// Retrieve the updates from the database
	$query_posts = "SELECT * FROM posts ORDER BY id DESC";
	$result_posts = mysqli_query($conn, $query_posts);
	
	// Display the updates
	while($row = mysqli_fetch_assoc($result_posts)) {
		echo "<div id='post'>";
		echo "<h2>" . formatDate($row['date']) . ": " . $row['title'] . "</h2>";
		echo "<p>" . $row['body'] . "</p>";
		echo "</div>";
	}

	mysqli_close($conn);

?>

