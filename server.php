<?php 
	date_default_timezone_set('UTC');
	session_start();
	$conn = mysqli_connect('localhost', 'root', '', 'miniproject');
?>

<?php

	// initialize variables
	$id = 0;
	$title = "";
	$content = "";
	$date_time = date('l jS \of F Y h:i:s A');
	$update = false;

	if (isset($_POST['save'])) 
	{
		$title = $_POST['title'];
		$content = $_POST['content'];

		mysqli_query($conn, "INSERT INTO `blog_post` (`title`, `content`) VALUES ('$title', '$content')"); 
		$_SESSION['message'] = "Blog saved"; 
		header('location: index.php');
	}
	else if (isset($_POST['update'])) 
	{
		$id = $_POST['id'];
		$title = $_POST['title'];
		$content = $_POST['content'];

		$sql = "UPDATE `blog_post` SET `title`='$title',`content`='$content' WHERE `id`=$id";
		
		mysqli_query($conn, $sql);

		$_SESSION['message'] = "Blog updated!"; 
		header('location: index.php');
	}

	else if (isset($_POST['comment'])) 
	{
		$id = $_POST['id'];
		$commentValue = $_POST['commentValue'];

		$sql = "UPDATE `blog_post` SET `comment`='$commentValue' WHERE `id`=$id";
		mysqli_query($conn, $sql);

		if($commentValue == '')
		{
			$_SESSION['message'] = "Comments on blog deleted!"; 
		} else {
			$_SESSION['message'] = "Blog commented!"; 
		}
		header('location: index.php');
	}

	else if (isset($_GET['del'])) 
	{
		$id = $_GET['del'];
		mysqli_query($conn, "DELETE FROM `blog_post` WHERE id=$id");
		$_SESSION['message'] = "Blog deleted!"; 
		header('location: index.php');
	}
	else {
		?>
		<script>
			console.log("NO FUNCTION");
		</script>
		<?php
	}

?>