<!doctype html>
<html>
<head>
    <title>Customer Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            background-color: #e6e6fa;s
            background-repeat: no-repeat;
            background-position: top left, bottom right, center;
            background-size: 100px, 120px, 80px;
        }
        form {
            border: 2px solid #ccc;
            padding: 20px;
            width: 100%;
            margin: 0 auto;
			background-color: white;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type=text], input[type=password], input[type=email] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Customer Registration Form</h2>
	<div style="margin-left:10%; margin-right:10%;background-color: white;" >
		<form action="processCustomer.php" method="post">
			Name: <input type="text" id="name" name="name"></input><br>
			Email: <input type="email" id="email" name="email"></input><br>
			Contact Number: <input type="text" id="phone" name="phone"></input><br>
			Username: <input type="text" id="username" name="username"></input><br>
			Password: <input type="password" id="password" name="password"></input><br>
			<input type="submit" value="Register" name="registerButton"> </input>
		</form>
	</div>
</body>
</html>