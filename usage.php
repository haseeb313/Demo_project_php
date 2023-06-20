<!DOCTYPE html>
<html>
<head>
<style>
        .postall {
            /* text-align: left; */
            margin-top: 10px;
            margin-bottom: 20px;
            padding: 10px;
            line-height: 0.1;
        }
        #myform {
            position: absolute;
            top: 20px;
            left: 800px;
        }
        .main {
            color: green;
            position: absolute;
            top: 300px;
            left: 800px;
        }
    </style>
</head>
<body>



<form id = "myform" method = "post" action = <?php echo $_SERVER["PHP_SELF"]; ?> >
<h3>Enter your credentials:</h3>
<input type = "text" id = "u1" name = "us" placeholder="Enter your Username" required>

<input type="password" id = "u2" name = "pass" placeholder="Enter your password" required /><br></br>

<textarea name="post" rows="6" cols="50" placeholder="Write a post or comment..."></textarea><br></br>
<button type ="submit" name="submit" value = "submit">Create a post</button>
<button type = "submit" name="update" value = "update">Update Post</button>
<button type = "submit" name="delete" value = "delete">Delete Post</button><br></br>

<input type = "number" id = "p1" name = "spost" placeholder="Post/Comment number">


<button type = "submit" name="comment" value = "Comment">Add Comment</button>
<button type = "submit" name="delcom" value = "delete">Delete Comment</button>


</form>


<div class = "postall" >
<?php
include 'db_config.php';
include 'users.php';
include 'posts.php';
include 'comments.php';

global $name;
echo "<h1>Posts and Comments</h1>";
$all = new Comment($conn);
$all->showCommentAll();

?>
</div>


<div class = "main">
    
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Posts

    if (isset($_POST['submit'])) {
        $name = $_POST["us"];
        $password = $_POST["pass"];
        $post = $_POST["post"];

        //users
        $a = new Users($conn);
        $a->create($name, $password);
        $c = $a->getId();
        
        //posts
        $b = new Post($conn);
        $b->create_post($post, $c);

        
    }

    if (isset($_POST['delete'])) {
        $name = $_POST["us"];
        $password = $_POST["pass"];
        $spost = $_POST["spost"];

        //users
        $a = new Users($conn);
        $u = $a->SelectUserN($name , $password);

        //posts
        $b = new Post($conn);
        $b->selectPost($spost);
        $p = $b->getUserId();


        if ($u === $p && (!empty($u) || !empty($p))) {
            $b->delete();
            echo "<p style ='color : red;'> <br>Note:<br> Post deleted successfully </p>" ;
        }
        elseif ($u === null && !empty($p)){
            echo "<p style ='color : red;'><br>Note:<br>Incorrect Username or Password</p>";
        }
        elseif ($p === null && (!empty($u))){
            echo "<p style ='color : red;'><br>Note:<br>Post not available</p>";
        }
        elseif ($u != $p && (!empty($u) || !empty($p))){
            echo "<p style ='color : red;'><br>Note:<br>This is not your Post</p>";
        }
        else{
            echo "<p style ='color : red;'>Note:<br>No post to delete</p>";
        }
        
    }

    if (isset($_POST['update'])) {
        $name = $_POST["us"];
        $password = $_POST["pass"];
        $spost = $_POST["spost"];
        $update = $_POST["post"];

        //users
        $a = new Users($conn);
        $u = $a->SelectUserN($name , $password);

        //posts
        $b = new Post($conn);
        $b->selectPost($spost);
        $p = $b->getUserId();


        if ($u === $p && (!empty($u) || !empty($p))) {
            $b->update($update);
            echo "<p style ='color : red;'><br>Note:<br> Post updated successfully</p>";
        }
        elseif ($u === null && !empty($p)){
            echo "<p style ='color : red;'><br>Note:<br>Incorrect Username or Password</p>";
        }
        elseif ($p === null && (!empty($u))){
            echo "<p style ='color : red;'><br>Note:<br>Post not available</p>";
        }
        elseif ($u != $p && (!empty($u) || !empty($p))){
            echo "<p style ='color : red;'><br>Note:<br>This is not your Post</p>";
        }
        else{
            echo "<p style ='color : red;'>Note:<br>No post to update</p>";
        }
        
    }







// Comments


    if (isset($_POST['comment'])) {
        $name = $_POST["us"];
        $password = $_POST["pass"];
        $comment = $_POST["post"];
        $spost = $_POST["spost"];

        //users
        $a = new Users($conn);
        $a->create($name, $password);
        $d = $a->getId();

        //posts
        $b = new Post($conn);
        $b->selectPost($spost);
        $p = $b->getPostId();

        //comments
        if($p === null){
            echo "<p style ='color : red;'><br>Note:<br>No post available to comment</p>";

        }
        else{
            $c = new Comment($conn);
            $c->create_comment($comment, $d , $spost);
        }

    }


    if (isset($_POST['delcom'])) {
        $name = $_POST["us"];
        $password = $_POST["pass"];
        $spost = $_POST["spost"];

        //users
        $a = new Users($conn);
        $u = $a->SelectUserN($name , $password);

        //posts
        $b = new Comment($conn);
        $b->selectComment($spost);
        $p = $b->getUserId();


        if ($u === $p && (!empty($u) || !empty($p))) {
            $b->deleteComment();
            echo "<p style ='color : red;'><br>Note:<br>Comment deleted successfully</p>";
        }
        elseif ($u === null && !empty($p)){
            echo "<p style ='color : red;'><br>Note:<br>Incorrect Username or Password</p>";
        }
        elseif ($p === null && (!empty($u))){
            echo "<p style ='color : red;'><br>Note:<br>Comment not available</p>";
        }
        elseif ($u != $p && (!empty($u) || !empty($p))){
            echo "<p style ='color : red;'><br>Note:<br>This is not your Comment</p>";
        }
        else{
            echo "<p style ='color : red;'>Note:<br>No Comment to delete</p>";
        }
        
    }
   
}

?>
</div>

</body>
</html>
