<?php
	function connect(){
		$connection = mysqli_connect("localhost", "root", "", "facility_information");
		return $connection;
	}
?>