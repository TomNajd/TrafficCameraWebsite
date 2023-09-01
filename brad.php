<DOCTYPE HTML>

<h2>LOCAL RADIO</h2>

<form method="POST">
<label for="events">City:</label>
<select name="events">

<?php

session_start();

$conn = new mysqli("localhost","root","","digi3");
if($conn->connect_error){
	die("connection failed: " . $conn->connect_error);
}

$option = 'SELECT DISTINCT City FROM events WHERE city = "Brisbane City"';
$option_result = $conn->query($option);
while($option_data = $option_result->fetch_array()) {

echo '<option>'.$option_data["City"].'</option>';

}
?>

</select>
<input name="submit" type="submit" value="submit">
</form>

<?php

if(isset($_POST['submit'])){


		$bradecho = $_POST['events'];

		echo '<p>'. "You have selected: " . $bradecho . '</p>';

		$option2 = "SELECT * FROM events WHERE  `city`= '$bradecho' ORDER BY `events`.`start` DESC" ;

		$option2result = $conn->query($option2);

		echo "<table border = '1'>";

		while($row = $option2result->fetch_assoc()){

		
			echo "<tr>";
		
			echo "<td><b> Event: </b>$row[event]</td>";

			echo "<td><b> Impacted Lanes: </b>$row[impact] </td>";

			echo "<td><b> Towards: </b> $row[towards] </td>";

			echo "<td><b> Direction: </b> $row[direction] </td>";

			echo "<td><b> Road Name: </b> $row[roadname] </td>";

			echo "<td><b> City: </b> $row[city] </td>";

			echo "<td><b> Start Date: </b> $row[start] </td>";

			echo "<td><b> End Date: </b> $row[end] </td>";

			echo "<td><b> advice: </b> $row[advice] </td>";

			echo "</tr>";
	
			
		}

		echo "</table>";
}

?>

<form method="POST">
<label for="webcams">Webcams:</label>
<select name="webcams">

<?php

$conn = new mysqli("localhost","root","","digi3");
if($conn->connect_error){
	die("connection failed: " . $conn->connect_error);
}

$option3 = 'SELECT description FROM webcams';
$option_result3 = $conn->query($option3);
while($option_data3 = $option_result3->fetch_array()) {

echo '<option>'.$option_data3["description"].'</option>';

}
?>

</select>
<input name="submit_webcam" type="submit" value="submit">
</form>

<?php

if(isset($_POST['submit_webcam'])){


		$bradecho2 = $_POST['webcams'];

		echo '<p>'. "You have selected: " . $bradecho2 . '</p>';

		$optionquery3 = "SELECT * FROM webcams WHERE  `description`='".$bradecho2."'";

		$option3result = $conn->query($optionquery3);
		
		echo "<table border = '1'>";

		while($row=2  $option3result->fetch_assoc()){

			echo "<tr>";
			
			$image= $row2['URL'];

			echo "<td>";
			echo "<img src='$image' class='center'>";
			echo "</td>";

			echo "<td><b> description: </b>$row2[description]</td>";

			echo "</tr>";	
		}	
		echo "</table>";
}




?>