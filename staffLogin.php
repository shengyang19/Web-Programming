<!doctype html>
<html>
<head>
    <title>Facility Booking System</title>
    <style>
        body {
            background-color: #87CEEB;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
        }
        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        fieldset {
            border: none;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            text-decoration: none;
            color: #333;
            display: block;
            margin-top: 10px;
            text-align: center;
        }
        p {
            margin: 10px 0;
            text-align: center;
        }
    </style>
    <script>
        function checkIfEmpty(){
            var name = document.getElementById("name").value;
            var pass = document.getElementById("pass").value;
            
            if(name == "" || pass == ""){
                alert("Fill in the blanks");
                return false;
            }else{
                return true;
            }
        }
    </script>
</head>

<body>
    <h1>Welcome to the Facility Booking Website!</h1>
    <h2>Logging In</h2>
    <form action="loginProcess_staff.php" method="post" onsubmit="return checkIfEmpty()">
        <fieldset>
            <label for="id">Identification</label>
            <input type="text" name="id" id="id"><br><br>
            <label for="name">Username</label>
            <input type="text" name="name" id="name"><br><br>
            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass"><br><br>
            <input type="submit" value="LOG IN">
            <a href="register.php">Forgot Password?</a>
            <a href="login.php">User Login</a>
        </fieldset>
    </form>
</body>

</html>
