<?php 

// ANVÄNDS EJ, MEN BÖR SPARAS, DETTA ÄR EN GAMMAL VERSION!!!

require "header.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE ) {

	$stmt = $conn->stmt_init();

	$query  = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name ";
	$query .= "FROM posts ";
	$query .= "LEFT JOIN users ON posts.user_id = users.user_id ";
	$query .= "LEFT JOIN categories ON posts.cat_id = categories.cat_id ";
	$query .= "WHERE post_id = ";
	$query .= $_GET['editid'];

	if (mysqli_query($conn, $query) ) {

	if($stmt->prepare($query)) {
		$stmt->execute();
		$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);

		while(mysqli_stmt_fetch($stmt)) {
			

	//-----------------------------------------------------------------------------
	// HTML-STRUKTUR FÖR INLÄGG
	//-----------------------------------------------------------------------------

	?>
	<h1>Blogginlägg</h1>

	<form method="POST" action="dashboard.php">
		<p>Rubrik</p>
		<input type="text" name="blogpost_title" value="<?php echo "$title"; ?>"><br>
		<p>Text</p>
		<textarea rows="15" cols="80" name="blogpost_text"> <?php echo "$text"; ?> </textarea><br>
		<select name="category"> 
			<option value ="0">Välj kategori</option>
			<option value ="1">Sport</option>
			<option value ="2">Mode</option>
			<option value ="3">Fotografi</option>
			<option value ="4">Annat</option>
		</select><br>
		<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera redigering">
		<input name="draft" class="btn btn-lg btn-primary btn-block" type="submit" value="Spara redigering till utkast">
	</form>
	<?php 
//-----------------------------------------------------------------------------
// PUBLISH
//-----------------------------------------------------------------------------
		}
	}
}
	if(isset($_POST["publish"])) {
		if(	!empty($_POST["blogpost_title"]) &&
			!empty($_POST["blogpost_text"]) &&
			$_POST["category"] != "0" ) {

			// Preparing the statement
			$stmt = $conn->stmt_init();
			
			// Stripping off harmful characters
			$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
			$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

			$timeStamp = date("Y-m-d H:i:s");
			$category = $_POST["category"];
			$editId = $_GET['editid'];

			// Update posts with new content as entered in previous form
			$query = "
				UPDATE posts
				SET title = 'tjenis',
				text = 'yo'
				WHERE post_id = 161
			";



			// if($stmt->prepare($query)) {
			// 	$stmt->execute();
			// }

			echo $query;
			// header("Refresh:0");
			if ( mysqli_query($conn, $query)) {
					echo "Ditt inlägg är sparat i databasen";
			} else {
					echo "Inlägget är inte sparat i databasen";
			}
		} else { echo "Du har inte fyllt i alla fält eller valt kategori"; } 
	}
} else {
	echo "Du är inte inloggad!";
}

?>

</body>
</html>