<DOCTYPE HTML>

<h2> DAILY COMMUTER </h2>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'digi3');
if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);			
	}

?>

<form method="POST">
<label for="Broadname"><b>BRISBANE ROADS WITH LIVE EVENTS:</b></label><br>
<select name="Broadname"><br>

<?php

$option = 'SELECT DISTINCT roadname FROM events WHERE city = "Brisbane City"';
$option_result = $conn->query($option);
while($option_data = $option_result->fetch_array()) {

echo '<option>'.$option_data["roadname"].'</option>';

}

?>

<input name="submit" type="submit" value="submit">
</select>
</form>

<?php

if(isset($_POST["submit"])){

  $kateecho = $_POST['Broadname'];

  echo '<p>'. "You have selected: " . $kateecho . '</p>';

  $option2 = "SELECT event, impact, towards, direction, roadname, advice FROM events WHERE  `roadname`= '$kateecho'" ;

  $option2result = $conn->query($option2);

  echo "<table border = '1'>";

  while($row = $option2result->fetch_assoc()){

  
    echo "<tr>";
  
    echo "<td><b> Event: </b>$row[event]</td>";

    echo "<td><b> Impacted Lanes: </b>$row[impact] </td>";

    echo "<td><b> Towards: </b> $row[towards] </td>";

    echo "<td><b> Direction: </b> $row[direction] </td>";

    echo "<td><b> Road Name: </b> $row[roadname] </td>";

    echo "<td><b> advice: </b> $row[advice] </td>";

    echo "</tr>";

    
  }

  echo "</table>";
}




?>