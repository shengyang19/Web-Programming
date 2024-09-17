<?php
			
			$connection = mysqli_connect("localhost", "root", "", "facility_information");
			
			$username = $_POST["name"];
			$password = $_POST["pass"];
			$id = $_POST["id"];
			
			//check if username is available
			//if available then insert
			
			if(checkUser($connection, $id, $username)){
				$queryInsert = "INSERT INTO customer_info(customer_id, customer_name, customer_password) VALUES('$id', '$username', '$password')";
				$insertUser = mysqli_query($connection, $queryInsert);
				echo "<script>";
				echo "alert('Success!'); </script>";
				header("refresh:0.1; url=login.php");
				exit;
			}else{
				echo "<script>";
				echo "alert('User already exists!'); </script>";
				header("refresh:0.1; url=register.php");
				exit;
			}
			mysqli_close($connection);
			
			function checkUser($connection, $id, $username){
				$query = "SELECT COUNT(*) FROM customer_info WHERE customer_id ='$id' OR customer_name = '$username'";
				$connect = mysqli_query($connection, $query);
				$total = mysqli_fetch_column($connect);
				if($total == 0)
					return true;
				else
					return false;
		}
		?>