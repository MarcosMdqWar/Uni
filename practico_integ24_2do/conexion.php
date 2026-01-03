<?php 

$conn = mysqli_connect("localhost", "root", "", "practico_integ_2do");
if (empty($conn)) {
	die("mysqli_connect failed: " . mysqli_connect_error());
	mysqli_close($conn);
}
else
	//print "connected to " . mysqli_get_host_info($conn) . "\n";


?>