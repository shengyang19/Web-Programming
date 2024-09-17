<?php
			
			$connection = mysqli_connect("localhost", "root", "", "facility_information");
			
			$username = $_POST["name"];
			$password = $_POST["pass"];
			$identification = $_POST['id'];
			
			session_start();
			$_SESSION['username'] = $_POST['name'];
			
			
			
			//check if username is available
			//if available then insert
			
			if(checkUser($username, $connection, $password, $identification)){
				echo "success!";
				header('Location: '.'mainStaff.php');
				exit;
			}else{
				echo "<script>";
				echo "alert('Invalid username or password!'); </script>";
				header("refresh:0; url=staffLogin.php");
				exit;
			}
			mysqli_close($connection);
			
			
			function checkUser($username, $connection, $password, $identification){
				$query = "SELECT COUNT(*) FROM staff_info WHERE staff_name ='$username' AND staff_password = '$password' AND staff_id = '$identification'";
				$connect = mysqli_query($connection, $query);
				$total = mysqli_fetch_column($connect);
				if($total > 0){
					return true;
				}else{
					return false;
				}
		}
		?>