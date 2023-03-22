<?php  include('server.php'); ?>

<?php
 if (!$_SESSION["username"])
 {
     header("Location: login.php");
     exit();
 }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Blog Post</title>
    <link rel="stylesheet" type="text/css" href="indexStyle.css">
</head>

<body>
    <?php  include('navi.php'); ?>


    <?php  
        $userType = $_SESSION['userType'];
        //echo 'userType = '. $userType; 
    
    ?>
    <?php
    
        $results = mysqli_query($conn, "SELECT * FROM blog_post order by ID desc"); 
        //echo("list mode");
    ?>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Date and Time</th>
                <?php 
                    if($userType == 'admin'){
                ?>
                <th colspan="3" style="text-align: center">Action</th>
                <?php }?>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($results)) 
        { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['content']; ?></td>
            <td><?php echo $row['date_time']; ?></td>

            <?php
            if($userType == 'admin')
            {
            ?>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn">Edit</a>
            </td>
            <td>
                <a href="server.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
            </td>
            <?php
            }?>
            <td>
            <a href="index.php?comment=<?php echo $row['id']; ?>"class="c_btn">Comment</a>
            </td>

        </tr>
        <?php } ?>
    </table>


    <?php
	if (isset($_GET['create'])) 
    {
        //printf("create mode")
        // $whatIsCreate = $_GET['create'];
        // echo $_GET['create'];
    ?>
    <form id="createForm" name="createForm" method="post" action="server.php">
        <p>Create Blog:</p>
        <div class="input-group">
            <label>Title</label>
            <input id="title" type="text" name="title" value="<?php echo ''.$title; ?>">
        </div>
        <div class="input-group">
            <label>Content</label>
            <textarea id="content" type="text" name="content"><?php echo ''.$content; ?></textarea>
        </div>
        <div class="input-group">
            <button class="btn" type="submit" name="save" onclick="javascript:checkBlogFormInput()">Save Blog</button>
            <!-- <input type="button" class="btn" name="clearBlog" onclick="javascript:clearFunction()" value="Clear Blog" /> -->
            <button class="btn" name="clearBlog" onclick="javascript:clearFunction(); return false;">Clear Blog</button>
        </div>
    </form>

    <?php
    }
    ?>


    <?php
	if (isset($_GET['edit'])) 
    {
        $update = true;
        $blogId = $_GET['edit'];
        // printf ("into edit mode for id===> ");
        // printf ($blogId);
        // printf("<br>");
        // run SELECT query 
        // then get results
        // show result

        $sql = "SELECT `id`, `title`, `content`, `date_time` FROM `blog_post` WHERE `id` = $blogId"; // id should be coming from List page

        $result = mysqli_query($conn, $sql);
        $arrayData = mysqli_fetch_all($result);
        $title = $arrayData[0][1]; // fetching the title
        $content = $arrayData[0][2]; // fetching content
        ?>
    <form name="updateForm" method="post" action="server.php">
        <input type="hidden" name="id" value="<?php echo $blogId; ?>">
        <p>Update Blog:</p>
        <div class="input-group">
            <label>Title</label>
            <input type="text" id="title" name="title" class="clearForm" value="<?php echo $title; ?>">
        </div>

        <div class="input-group">
            <label>Content</label>
            <textarea rows="50" cols="40" id="content" type="text" class="clearForm"
                name="content"><?php echo $content; ?></textarea>
        </div>
        <div class="input-group">
            <button class="btn" type="submit" name="update" onclick="javascript:checkBlogFormInput()">Update Blog</button>
            <!-- <input type="button" class="btn" name="clearBlog" onclick="javascript:clearFunction()" value="Clear Blog" /> -->
            <button class="btn" name="clearBlog" onclick="javascript:clearFunction(); return false;">Clear Blog</button>
        </div>
    </form>
    <?php
    }
    ?>


<?php
	if (isset($_GET['comment'])) 
    {
        $blogId = $_GET['comment'];

        $sql = "SELECT `id`, `title`, `comment` FROM `blog_post` WHERE `id` = $blogId"; // id should be coming from List page

        $result = mysqli_query($conn, $sql);
        $arrayData = mysqli_fetch_all($result);
        $title = $arrayData[0][1]; // fetching the title
        $comment = $arrayData[0][2]; // fetching comment
        ?>

    <form name="commentForm" method="post" action="server.php">
        <input type="hidden" name="id" value="<?php echo $blogId; ?>">
        <p>Blog comment:</p>
        <div class="input-group">
            <label>Title</label>
            <input type="text" id="title" name="title" class="clearForm" value="<?php echo $title; ?>" disabled>
        </div>

        <div class="input-group">
            <label>Comments</label>
            <textarea id="commentValue" type="text" class="clearForm"
                name="commentValue"><?php echo $comment; ?></textarea>
        </div>
        <div class="input-group">
            <?php 
            if($userType == 'admin'){
            ?>
            <button class="btn" type="submit" name="comment">Comment</button>
            <button class="btn" name="comment" type="submit" onclick="javascript:clearComment(); return true;">Delete</button>
            <?php 
            }
            else if($userType == 'user'){
            ?>
            <button class="btn" name="comment" type="submit" onclick="javascript:checkCommentInput();">Comment</button>
            <?php
            }
            ?>
        </div>
    </form>
    <?php
    }
    ?>




    <?php 
        if($userType == 'admin' && !(isset($_GET['create'])) ){
    ?>
        <form method="post" action="index.php">
            <a href="index.php?create=0" class="btn" id="createBlog">Create Blog</a>
        </form>

    <?php
    }
    ?>

    <script>
    function clearFunction() {
        document.getElementById('title').value = '';
        document.getElementById('content').value = '';
    }
    
    function checkBlogFormInput(e) {
        var u = document.getElementById("title").value;
        var p = document.getElementById("content").value;
        if (u == '' || p == '') {
            document.getElementById('title').style.borderColor = "red";
            document.getElementById('content').style.borderColor = "red";
            e = e || window.event;
            e.preventDefault();
        } else {
            return true;
        }
    }
    
    function clearComment() {        
        document.getElementById('commentValue').value = '';
    }

    function checkCommentInput(e) {
        var p = document.getElementById("commentValue").value;
        if (p == '') {            
            document.getElementById('commentValue').style.borderColor = "red";
            e = e || window.event;
            e.preventDefault();
        } else {
            return true;
        }
    }


    </script>    

<?php if (isset($_SESSION['message'])): ?>
    <div class="msg">
        <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
    </div>
    <?php endif ?>

</body>

</html>