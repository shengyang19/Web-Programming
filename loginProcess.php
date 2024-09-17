<?php
			
			$connection = mysqli_connect("localhost", "root", "", "facility_information");
			
			$username = $_POST["name"];
			$password = $_POST["pass"];
			
			session_start();
			$_SESSION['username'] = $_POST['name'];
			
			
			
			//check if username is available
			//if available then insert
			
			if(checkUser($username, $connection, $password)){
				echo "success!";
				header('Location: '.'mainCustomer.php');
				exit;
			}else{
				echo "<script>";
				echo "alert('Invalid username or password!'); </script>";
				header("refresh:0.1; url=login.php");
				exit;
			}
			mysqli_close($connection);
			
			function errorMessage(){
				
			}
			
			function checkUser($username, $connection, $password){
				$query = "SELECT COUNT(*) FROM customer_info WHERE customer_name ='$username' AND customer_password = '$password'";
				$connect = mysqli_query($connection, $query);
				$total = mysqli_fetch_column($connect);
				if($total > 0){
					return true;
				}else{
					return false;
				}
		}
		?>