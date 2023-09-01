<?php
$servername="localhost";
$database="digi3";
$username="root";
$password="";

$conn = mysqli_connect($servername,$username,$password,$database);
if ($conn->connect_error){
  die("connection failed:". $conn->connect_error);
}

$table_query = $conn->prepare("CREATE TABLE IF NOT EXISTS Login(Username VARCHAR(50),
                                      Password VARCHAR(50))");
$table_query -> execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <form action="" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="Username" name="Username" class="form-control">
               
            </div>  

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control"><br>
       
            </div>
            <div class="form-group">
                <input type="submit" name="submit_button" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST["submit_button"])){
$sql = "SELECT Username, Password FROM login";
$mysqlresult = mysqli_query($conn,$sql);


while ($buffer = mysqli_fetch_array($mysqlresult, MYSQLI_NUM)) {
if (($buffer[0] == $_POST['Username']) AND ($buffer[1] == $_POST['password'])) {
     header("Location: brad.php");
 }
 while ($buffer = mysqli_fetch_array($mysqlresult, MYSQLI_NUM)) {
 if (($buffer[0] == $_POST['Username']) AND ($buffer[1] == $_POST['password'])) {
    header("Location: rob.php");    
  }
  while ($buffer = mysqli_fetch_array($mysqlresult, MYSQLI_NUM)) {
    if (($buffer[0] == $_POST['Username']) AND ($buffer[1] == $_POST['password'])) {
       header("Location: Kate.php");    
     }
    }

}
    }    
}

?>