<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die ("error " . $conn->connect_error);
}
// else{
//     echo "connection successful";
// }


//------- USERS--------

$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql_users);

// if ($conn->query($sql_users) === True){
//     echo "<br> table created successfully";
//     // return true;
// }
// else {
//     echo $conn->error;

// }


//-----------POSTS------------

$sql_posts = "CREATE TABLE IF NOT EXISTS posts(
    id INT(6)  AUTO_INCREMENT PRIMARY KEY,
    post_con TEXT NOT NULL,
    user_id INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)

)";
$conn->query($sql_posts);
// if ($conn->query($sql_posts) === True){
//     echo "<br> table created successfully";
//     // return true;
// }
// else {
//     echo "<br>" . $conn->error;

// }

//-------------------comments------------

$sql_comments = "CREATE TABLE IF NOT EXISTS comments(
    id INT(6)  AUTO_INCREMENT PRIMARY KEY,
    comments TEXT NOT NULL,
    user_id INT(11) NOT NULL,
    post_id INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES posts(id)

)";
$conn->query($sql_comments)
// if ($conn->query($sql_comments) === True){
//     echo "<br> table created successfully";
//     // return true;
// }
// else {
//     echo "<br>" . $conn->error;
// }

?>





