<DOCTYPE HTML>

<h2>TRANSPORT TM</h2>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'digi3');
if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);			
	}
 
$conn = mysqli_connect('localhost', 'root', '', 'digi3');
$table_query = $conn->prepare("CREATE TABLE IF NOT EXISTS Robinput(roadname VARCHAR(50),
                                      alert VARCHAR(50))");
$table_query -> execute();

?>

<form method="POST">
<label for="RDname">Road Name:</label><br>
<select name="RDname"><br>

<?php

$option = 'SELECT DISTINCT roadname FROM events';
$option_result = $conn->query($option);
while($option_data = $option_result->fetch_array()) {

echo '<option>'.$option_data["roadname"].'</option>';

}

?>

<input name="submit" type="submit" value="submit">
</select>
</form>

<form method="POST">
<label for="rname">Road name:</label><br>
<input type="text" id="rname" name="rname"><br>
<label for="aname">Alert:</label><br>
<input type="text" id="aname" name="aname"><br>
<input name="submitI" type="submit" value="submit"><br>

</form>

<?php

if(isset($_POST['submit'])){

    $robecho = $_POST['RDname'];

		//echo '<p>'. "You have selected: " . $robecho . '</p>';

		$option2 = "SELECT event, start, end FROM events WHERE  `roadname`= '$robecho'";

		$option2result = $conn->query($option2);

		echo "<table border = '1'>";

		while($row = $option2result->fetch_assoc()){

      echo "<tr>";
		
			echo "<td><b> Event: </b>$row[event]</td>";

      echo "<td><b> Start: </b>$row[start]</td>";

      echo "<td><b> End: </b>$row[end]</td>";

      echo "</tr>";

    }
    

    echo "</table>";
  }


elseif(isset($_POST['submitI'])){

    $robinsert = $_POST["rname"];

    $robinsert2 = $_POST["aname"];

    $option = $conn->prepare("INSERT INTO `robinput`(`roadname`, `alert`) VALUES ('$robinsert','$robinsert2')");

    $option->execute();

    echo '<p>'. "<b>you have inserted: </b>" . $robinsert . "<b> and </b>" . $robinsert2 . '</p>';

}



?>