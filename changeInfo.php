<!doctype html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #f4a460;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 15px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function checkIfEmpty() {
            var name = document.getElementById("name").value;
            var id = document.getElementById("id").value;
            var password = document.getElementById("password").value;

            if (name == "" || password == "" || id == "") {
                alert("Fill in the blanks");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Edit Profile</h1>

    <?php
    include 'database.php';
    session_start();

    $username = $_SESSION['username'];
    if ($username == NULL) {
        echo "<script> alert('Please login again'); </script>";
        header("refresh:0.1; url=login.php");
        exit();
    }

    $connection = connect();
    $query = "SELECT * FROM customer_info WHERE customer_name = '$username'";
    $find = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($find);

    $id = $row['customer_id'];
    $name = $row['customer_name'];
    $password = $row['customer_password'];

    if (!isset($_POST['edit'])) {
        profile($id, $name, $password);
    } else {
        edit($id, $name, $password);
    }

    if (isset($_POST['exit'])) {
        header("refresh:0.1; url=mainCustomer.php");
        exit();
    }

    if (isset($_POST['save'])) {
        saveInfo($id);
    }

    function profile($id, $name, $password) {
        echo "<form method='post'>";
        echo "<label for='id'>Identification:</label> <input type='text' value='$id' readonly id='id'><br>";
        echo "<label for='name'>Username:</label> <input type='text' value='$name' readonly id='name'><br>";
        echo "<label for='password'>Password:</label> <input type='password' value='$password' readonly id='password'><br>";
        echo "<br><input type='submit' name='edit' value='Edit Profile'>";
        echo "<input type='submit' name='exit' value='Exit'>";
        echo "</form>";
    }

    function edit($id, $name, $password) {
        echo "<form method='post' onsubmit='return checkIfEmpty()'>";
        echo "<label for='id'>Identification:</label> <input type='text' value='$id' name='idNew' id='id'><br>";
        echo "<label for='name'>Username:</label> <input type='text' value='$name' name='usernameNew' id='name'><br>";
        echo "<label for='password'>Password:</label> <input type='password' value='$password' name='passwordNew' id='password'><br>";
        echo "<br><input type='submit' name='save' value='Save Profile'>";
        echo "<input type='submit' name='cancel' value='Cancel Edits'>";
        echo "</form>";
    }

    function saveInfo($id) {
        global $connection;
        $newId = $_POST['idNew'];
        $newName = $_POST['usernameNew'];
        $newPassword = $_POST['passwordNew'];
        $query = "UPDATE customer_info SET customer_id = '$newId', customer_name = '$newName', customer_password = '$newPassword' WHERE customer_id = '$id'";
        if (mysqli_query($connection, $query)) {
            $_SESSION['username'] = NULL;
            mysqli_close($connection);
            echo "<script> alert('Success!'); </script>";
            header("refresh:0.1; url=login.php");
            exit();
        } else {
            echo "<script> alert('Error!'); </script>";
        }
    }
    ?>
</div>
</body>
</html>
