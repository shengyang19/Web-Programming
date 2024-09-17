<!doctype html>
<html>
<head>
    <title>Facility Booking System</title>
    <style>
        body {
            background-color: #f3d9dc;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        form {
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="submit"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function checkIfEmpty() {
            var name = document.getElementById("name").value;

            if (name == "") {
                alert("Fill in the blanks");
                return false;
            } else {
                return true;
            }
        }

        function areYouSure() {
            if (confirm("Are you sure you want to unrent?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<body>
<div id="main-container">
    <?php
    session_start();

    $username = $_SESSION['username'];
    if ($username == NULL) {
        echo "<script> alert('Please login again'); </script>";
        header("refresh:0.1; url=login.php");
        exit();
    }

    echo " <h2> Welcome $username!</h2>";

    $connection = mysqli_connect("localhost", "root", "", "facility_information");
    $getCustomerId = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM customer_info WHERE customer_name LIKE '$username'"));
    $customerId = $getCustomerId['customer_id'];

    if (isset($_GET['logout'])) {
        logOut($connection);
    }

    function logOut($connection) {
        $_SESSION['username'] = NULL;
        mysqli_close($connection);
        header("refresh:0.1; url=login.php");
        exit();
    }

    ?>


    <h1>Facility Booking Website</h1>
    <?php
    displayFacility();

    function displayFacility() {
        $query = "SELECT * FROM facility_info";
        $facility = mysqli_query($GLOBALS['connection'], $query);

        echo "<table border='1px'>
                <tr> 
                    <th> Facility Id </th>
                    <th> Name of Facility </th>
                    <th> Renting Price </th>
                    <th> Rent now! </th>
                </tr>";
        while ($row = mysqli_fetch_assoc($facility)) {
            echo "<tr>" ;
            echo "<td> " . $row['facility_id'] . "</td>";
            echo "<td> " . $row['facility_name'] . "</td>";
            echo "<td> " . $row['facility_price'] . "</td>";
            if ($row['customer_id'] == NULL) {
                echo "<td> <form method='post'> <input type='hidden' name='row_id' value='" . $row['facility_id'] . "'> <input type='submit' name='submitBtn' value='Rent'> </form> </td>";
            } else {
                echo "<td> Is already booked </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    if (isset($_POST['submitBtn'])) {
        rentFacility();
    }

    function rentFacility() {
        $rowName = $_POST['row_id'];
        $queryFacility = mysqli_query($GLOBALS['connection'], "UPDATE facility_info SET customer_id = '" . $GLOBALS['customerId'] . "' WHERE facility_id = '$rowName'");

        if ($queryFacility) {
            //create script code to remind if want to delete
            echo "<script> alert('Successfully Rented!'); </script>";
            header("refresh:0; url=mainCustomer.php");
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    ?>

    <h2> Facility currently renting </h2>
    <?php
    currentlyRenting();

    function currentlyRenting() {
        $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM facility_info WHERE customer_id = '" . $GLOBALS['customerId'] . "'");


        echo "<table border='1px'>
                <tr> 
                    <th> Facility Id </th>
                    <th> Name of Facility </th>
                    <th> Rented by customer </th>
                    <th> Unrent </th>
                </tr>";
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>" ;
            echo "<td> " . $row['facility_id'] . "</td>";
            echo "<td> " . $row['facility_name'] . "</td>";
            echo "<td> " . findName($row['customer_id'], $GLOBALS['connection']) . "</td>";
            echo "<td> <form method='post' onsubmit='return areYouSure()'> <input type='hidden' name='facilityId' value='" . $row['facility_id'] . "'/> <input type='submit' name='unrent' value='Unrent'> </form> </td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if (isset($_POST['unrent'])) {
        unrent();
    }

    function unrent() {
        $rowName = $_POST['facilityId'];
        $queryFacility = mysqli_query($GLOBALS['connection'], "UPDATE facility_info SET customer_id = NULL WHERE facility_id = '$rowName'");

        if ($queryFacility) {
            //create script code to remind if want to delete
            echo "<script> alert('Successfully unrent!'); </script>";
            header("refresh:0; url=mainCustomer.php");
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    function findName($customer, $connection) {
        $query = mysqli_query($connection, "SELECT * FROM customer_info WHERE customer_id LIKE '$customer'");
        $find = mysqli_fetch_assoc($query);
        if ($find) {
            $result = $find['customer_name'];
            return $result;
        } else {
            return "-";
        }
    }

    ?>

    <br>
    <h2> Search a facility! </h2>
    <form method='post' onsubmit="return checkIfEmpty()"> Search for your facility! : <input type="text" name="name"
                                                                                                   id="name"> <input
                type="submit" value="Submit" name="submit"> </form> <br>
    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        if (findFacility($connection, $name)) {
            //echo " <form method='post'> <br> <input type='submit' name='rent' value='Rent'> </input> </form>";
        }
    }

    function findFacility($connection, $name) {
        $query = mysqli_query($connection, "SELECT * FROM facility_info WHERE facility_name LIKE '$name'");
        if (mysqli_num_rows($query) > 0) {
            echo "<table border='1px'>
                <tr> 
                    <th> Facility Id </th>
                    <th> Name of Facility </th>
                    <th> Rented by customer </th>
                    <th> Rent now! </th>
                </tr>";
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>" ;
                echo "<td> " . $row['facility_id'] . "</td>";
                echo "<td> " . $row['facility_name'] . "</td>";
                echo "<td> " . $row['facility_price'] . "</td>";
                if ($row['customer_id'] == NULL) {
                    echo "<td> <form method='post'> <input type='hidden' name='row_id' value='" . $row['facility_id'] . "'> <input type='submit' name='submitBtn' value='Rent'> </form> </td>";
                } else {
                    echo "<td> Is already booked </td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            return true;
        } else {
            echo '<b> not found </b>';
            return false;
        }

    }

    function rentingProcessing($facility_name) {
        echo " <form method='post'> <br> <input type='submit' name='$facility_name' value='Rent'> </form>";
    }
    ?>


    <br>
    <h2> Profile Setting </h2>
    <?php // get profile information
    //$_SESSION['id'] = $row['customer_id'];


    if (isset($_GET['changeInfo'])) {
        changeInfo($connection);
    }

    function changeInfo($connection) {
        mysqli_close($connection);
        header("refresh:0.1; url=changeInfo.php");
        exit();
    }

    ?>
    <a href="mainCustomer.php?changeInfo=true;"><input type="button" value="EDIT PROFILE"> </a>


    <br> <br>
    <a href="mainCustomer.php?logout=true;"><input type="button" value="LOG OUT"> </a>


</div>
</body>

</html>
