<?php
// include 'db_config.php';
// include 'users.php';


class Post {
    public $con;
    private $user_id;
    private $id;

    function __construct($con) {
        $this->con = $con;
    }

    function showAll(){
        $sql = "SELECT *, p.id as postId FROM posts p, users u WHERE u.id = p.user_id";
        $result = $this->con->query($sql);
        // print_r ($result);

        if ($result->num_rows > 0){
            $post_all = $result->fetch_all(MYSQLI_ASSOC);           
            
            foreach ($post_all as $post) {
                $this->post = $post["post_con"];
                $this->p_id = $post["postId"];
                $this->u_name =$post["username"];
                echo "<br>{$this->p_id}) {$this->u_name}: {$this->post}\n";
            }
        }
        elseif ($result->num_rows === 0){
            echo "<p>No post available</p>";
        }    
    }

    function create_post($content , $userId) {

        $sql_p = "INSERT INTO posts (post_con, user_id) VALUES ('$content', '$userId')";
        $ret = $this->con->query($sql_p);

        if ($ret === true) {
            echo "<br>Post created successfully";
        } else {
            echo "Error occurred";
        }
    }
    function selectPost($id){
        $sql = "SELECT * FROM posts WHERE id = '$id'";
        $result = $this->con->query($sql);
        if ($result->num_rows === 1) {
            $post = $result->fetch_assoc();
            $this->id = $post["id"];
            $this->post_con = $post["post_con"];
            $this->user_id = $post["user_id"];
        }

        else{
            return null;
        }
    }

    function showPost(){
        echo "<br> {$this->id} ) {$this->post_con}";
    }

    function delete(){

        if (empty($this->id)){
            return false;

        }
        else{
            $sql = "DELETE FROM posts WHERE id = '$this->id'";

            $result = $this->con->query($sql);
    
            if ($result === true) {
                return true;
            }
    
            else{
                echo "Error occurred";
            }
        }
    }
    function update($content) {

        
        if (empty($this->id)){
            return false;

        }
        else{
            $sql = "UPDATE posts SET post_con = '$content' WHERE id = '$this->id'";
        
            $result = $this->con->query($sql);
    
            if ($result === true) {
              $this->content = $content;
              return true;
    
            } 
            else{
                echo "Error occurred";
            }
        } 
                
        // $sql = "UPDATE posts SET content = '$content' WHERE id = '$this->id'";
        
        // $result = $this->con->query($sql);

        // if ($result === true) {
        //   $this->content = $content;
        //   return true;

        // } 
        // else{
        //     echo "Error occurred";
        // }
    }

    function getPostId(){
        return $this->id;
    }



    function getUserId(){
        return $this->user_id;
    }
}


// $q = new Users($conn);
// $q->create("haseeb", "pass");



// $b = new Post($conn);
// $b->create_post("why?", $q->getId());
// $b->selectPost(4);
// echo $b->getUserId();
// $b->delete();
// $b->showPost();


?>
