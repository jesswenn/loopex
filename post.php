<?php
include "header.php";
// include "dbconnect.php";

$stmt = $conn->stmt_init();

$query  = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name ";
$query .= "FROM posts ";
$query .= "LEFT JOIN users ON posts.user_id = users.user_id ";
$query .= "LEFT JOIN categories ON posts.cat_id = categories.cat_id ";
$query .= "WHERE post_id = ";
$query .= $_GET['id'];

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);

	while(mysqli_stmt_fetch($stmt)) {
		
	?>
        <div class="blogpost">
            <h1><?php echo $title; ?></h1>
            <div class="date"><p><?php echo $createTime; ?></p></div>
            <div class="text"><p><?php echo $text; ?></p></div>
            <div class="author"><p>Written by:
                <?php
                echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a>";
                echo "<p>Kategori: $catName</p>";
                ?>
            </div>
        </div>
        <div class="comments_to_post">
            <h2>Kommentarer</h2>
    		<form method="POST" action="post.php">
    			<p>Namn</p>
                <input type="text" name="blogpost_title"><br>
                <p>E-post</p>
                <input type="text" name="blogpost_title"><br>
                <p>Kommentar</p>
    			<textarea rows="5" cols="30" name="blogpost_text"></textarea><br>
    			<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera kommentar">
    		</form>
        </div>
      <?php   
	}
}
include "footer.php";
?>