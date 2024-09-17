<!DOCTYPE html>
<html>
<head>
    <title>Change Staff Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8B4513;
            margin: 0;
            padding: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
</html>
    <script>
		function checkIfEmpty(){
			var name = document.getElementById("name").value;
			var id = document.getElementById("id").value;
			var password document.getElementById("password").value;
			
			if(name == "" || password == "" || id == ""){
				alert("Fill in the blanks");
				return false;
			}else{
				return true;
			}
		}
</script>
	
<?php
	include 'database.php';
	session_start();

	$username = $_SESSION['username'];
	if($username == NULL){
		echo "<script> alert('Please login again'); </script>";
		header("refresh:0.1; url=login.php");
		exit();
	}
	
	$connection = connect();
	$query = "SELECT * FROM staff_info where staff_name LIKE '". $GLOBALS['username']."'"; 
	$find = mysqli_query($GLOBALS['connection'], $query);
	$row = mysqli_fetch_assoc($find);
	
	$id = $row['staff_id'];
	$name = $row['staff_name'];
	$password = $row['staff_password'];
	
	
	if(!isset($_POST['edit']))
		profile();
	else
		edit();
	
	if(isset($_POST['exit'])){
		header("refresh:0.1; url=mainStaff.php");
		exit();
	}
	
	if(isset($_POST['save'])){
		saveInfo($id);
	}
		
	function saveInfo($id){
		$newId = $_POST['idNew'];
		$newName = $_POST['usernameNew'];
		$newPassword = $_POST['passwordNew'];
		$query = "UPDATE staff_info SET staff_id = '$newId', staff_name = '$newName', staff_password = '$newPassword' WHERE staff_id = '$id'";
		if(mysqli_query($GLOBALS['connection'], $query)){
			$_SESSION['username'] = NULL;
			mysqli_close($connection);
			echo "<script> alert('Success!'); </script>";
			header("refresh:0.1; url=login.php");
			exit();
		}else{
			echo "<script> alert('Error!'); </script>";
		}
	}
	
	function profile(){
		
		echo "<form method='post'>";
		echo "Identification: <input type='text' value='".$GLOBALS['id']."'readonly> </input>";
		echo "<br>Username: <input type='text' value='".$GLOBALS['name']."'readonly> </input><br>";
		echo "Password: <input type='password' value='".$GLOBALS['password']."'readonly> </input><br>";
		echo "<br><input type='submit' name='edit' value='Edit Profile' action='changeInfoStaff.php?edit=true;'> </input>";
		echo "<input type='submit' name='exit' value='Exit' action='changeInfoStaff.php?exit=true;'> </input>";
		echo "</form>";
	}
	
	function edit(){
		echo "<form method='post' onsubmit='return checkIfEmpty()'>";
		echo "Identification: <input type='text' value='".$GLOBALS['id']."' name='idNew' id='id'> </input>";
		echo "<br>Username: <input type='text' value='".$GLOBALS['name']."' name='usernameNew' id='name'> </input><br>";
		echo "Password: <input type='text' value='".$GLOBALS['password']."' name='passwordNew' id='password'></input><br>";
		echo "<br><input type='submit' name='save' value='Save Profile' action='changeInfoStaff.php?save=true;'> </input>";
		echo "<input type='submit' name='cancel' value='Cancel Edits' action='changeInfoStaff.php;'> </input>";
		echo "</form>";
	}
?>
</body>
</html>
