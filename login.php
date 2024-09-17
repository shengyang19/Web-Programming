<!doctype html>
<html>
	<head>
		<title> Facility Booking System </title>
		<style>
			body {
				background-color: #e0f7fa;
				font-family: Arial, sans-serif;
			}

			h1, h2 {
				color: #007b8f;
				text-align: center;
			}

			fieldset {
				background-color: #ffffff;
				border: 2px solid #00acc1;
				border-radius: 10px;
				padding: 20px;
				width: 300px;
				margin: auto;
			}

			input[type="text"], input[type="password"] {
				width: 100%;
				padding: 8px;
				margin: 5px 0 15px 0;
				border: 2px solid #00acc1;
				border-radius: 5px;
				box-sizing: border-box;
			}

			input[type="submit"] {
				background-color: #00acc1;
				color: white;
				border: none;
				padding: 10px;
				width: 100%;
				border-radius: 5px;
				cursor: pointer;
			}

			input[type="submit"]:hover {
				background-color: #00838f;
			}

			a {
				color: #00acc1;
				text-align: center;
				display: block;
				margin-top: 10px;
				text-decoration: none;
			}

			a:hover {
				text-decoration: underline;
			}
		</style>
		<script>
			function checkIfEmpty() {
				var name = document.getElementById("name").value;
				var pass = document.getElementById("pass").value;

				if (name == "" || pass == "") {
					alert("Fill in the blanks");
					return false;
				} else {
					return true;
				}
			}
		</script>
	</head>

	<body>
		<h1> Welcome to the Facility Booking Website! </h1>
		<h2> Logging In </h2>
		<form action="loginProcess.php" method="post" onsubmit="return checkIfEmpty()">
			<fieldset>
				Username	<input type="text" name="name" id="name"> <br> <br>
				Password	<input type="password" name="pass" id="pass"> <br> <br>
				<input type="submit" value="LOG IN">
				<a href="register.php"> Forgot Password? </a>
				<a href="register.php"> Not yet registered? Sign Up </a>
				<a href="staffLogin.php"> Staff Login </a>
			</fieldset>
		</form>
	</body>
</html>
