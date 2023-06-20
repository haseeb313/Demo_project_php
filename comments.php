<?php
// include 'db_config.php';
// include 'users.php';
// include 'posts.php';


class Comment {
    public $con;
    private $user_id;

    function __construct($con) {
        $this->con = $con;
    }

    function showCommentAll(){
        $sql = "SELECT *,u.id as usId,p.id as poId,c.user_id as usID FROM users u LEFT JOIN posts p ON u.id = p.user_id LEFT JOIN comments c ON p.id = c.post_id ORDER BY `u`.`id` ASC";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $post_all = $result->fetch_all(MYSQLI_ASSOC);
            
            // print_r($post_all);

            $l = null;
            $k = null;
            
            foreach ($post_all as $post) {
                $this->usId = $post["usId"];
                $this->u_name = $post["username"];
                $this->pos = $post["post_con"];
                $this->com = $post["comments"];
                $this->post_id = $post["poId"];
                $this->com_id = $post["id"];
            
                if ($this->usId !== $l) {
                    if (!empty($this->pos)){
                        echo "<br><h2>{$this->usId}) {$this->u_name} :</h2>";
                        $l = $this->usId;
                    }

                }
            
                if ($this->post_id !== $k && !empty($this->post_id)) {
                    echo "<br><h3 style= 'margin-left : 50px;'>Post {$this->post_id}:</h3>  <h3 style= 'color: grey;margin-left : 60px;'>{$this->pos}:</h3>";
                    $k = $this->post_id;
                }
            
                if (!empty($this->com_id)) {
                    echo "<br> <h4 style= 'margin-left : 120px;'> Comment {$this->com_id}: </h4> <p style= 'color: grey;margin-left : 130px;'> {$this->com}</p>";

                }
            }
        }
        else {
            echo "<p>No posts available</p>";
        }
        


  
    }



    function create_comment($content , $userId , $postId) {

        $sql_p = "INSERT INTO comments (comments, user_id, post_id) VALUES ('$content', '$userId', '$postId')";
        $ret = $this->con->query($sql_p);

        if ($ret === true) {
            echo "<br>comments created successfully";
        } else {
            echo "Error occurred";
        }
    }

    function selectComment($id){
        $sql = "SELECT * FROM comments WHERE id = '$id'";
        $result = $this->con->query($sql);
        if ($result->num_rows === 1) {
            $comment = $result->fetch_assoc();
            $this->id = $comment["id"];
            $this->comments = $comment["comments"];
            $this->user_id = $comment["user_id"];
            $this->post_id = $comment["post_id"];
        }

        else{
            return null;
        }
    }

    function showComment(){
        echo "<br> {$this->id} ) {$this->comments}";
    }

    function deleteComment(){

        if (empty($this->id)){
            return false;
        }
        else{
            $sql = "DELETE FROM comments WHERE id = '$this->id'";

            $result = $this->con->query($sql);
    
            if ($result === true) {
                return true;
            }
    
            else{
                echo "Error occurred";
            }

        }
    }  
    
    function getUserId(){
        return $this->user_id;
    }
}


// $q = new Users($conn);
// $q->create("hasee", "pass");



// $b = new Comment($conn);
// $b->create_comment("why?", $q->getId() , 4);


// $b->selectComment(1);
// echo $b->getUserId();

// $b->deleteComment();

// $b->showComment();



// $b = new Comment($conn);
// $b->showCommentAll();


?>
