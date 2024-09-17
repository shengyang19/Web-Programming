<!DOCTYPE html>
<html>
<head>
    <title> Facility Booking System - STAFF </title>
    <style>
        body {
            background-color: #ffffcc;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width:100%;
			background:white;
			margin: auto 10;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
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
    </style>
</head>
<body>
<?php
session_start();

function refreshPage(){
    header('refresh:0');
}

$username = $_SESSION['username'];
if($username == NULL){
    echo "<script> alert('Please login again'); </script>";
    header("refresh:0.1; url=login.php");
    exit();
}

echo "<h2> Welcome $username!</h2>";

$connection = mysqli_connect("localhost", "root", "", "facility_information");
$faciltyChosen = NULL;

if(isset($_POST['logout'])){
    logOut($connection);
}

function logOut($connection){
    $_SESSION['username'] = NULL;
    mysqli_close($connection);
    header("refresh:0.1; url=login.php");
    exit();
}

if(isset($_POST['edit'])){
    changeInfo($connection);
}

function changeInfo($connection){
    mysqli_close($connection);
    header("refresh:0.1; url=staffInfo.php");
    exit();
}
?>
<h1>Facility Booking Website - STAFF</h1>
<?php
$query = "SELECT * FROM facility_info";
$facility = mysqli_query($connection, $query);
?>
<table border='1px'>
<tr>
    <td> <b> Facility Id </b> </td>
    <td> <b> Name of Facility </b> </td>
    <td> <b> Renting Price <b> </td>
    <td> <b> Rented By <b> </td>
</tr>
<?php
while($row = mysqli_fetch_assoc($facility)){
    echo "<tr>";
    echo "<td> " .$row['facility_id']. "</td>";
    echo "<td> " .$row['facility_name']. "</td>";
    echo "<td> " .$row['facility_price']. "</td>";
    $id = $row['customer_id'];
    if(isset($id)){
        echo "<td> " .getCustomerName($id). "</td>";
    }else{
        echo "<td> - </td>";
    }

    echo "</tr>";
}
echo "</table>";
mysqli_data_seek($facility, 0);

function getCustomerName($id){
    $customer = mysqli_query($GLOBALS['connection'], "SELECT * FROM customer_info WHERE customer_id LIKE '$id'");
    $row = mysqli_fetch_assoc($customer);
    if(isset($row['customer_name'])){
        mysqli_data_seek($customer, 0);
        return $row['customer_name'];
    }
    return '-';
}
?>
<br>
<h2> Search a facility! </h2>
<form method='post' onsubmit="return checkIfEmpty()">
    Search for your facility! :
    <input type="text" name="name" id="name">
    <input type="submit" value="Submit" name="submit">
</form>
<br>
<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    if(findFacility($connection, $name)){
        //echo " <form method='post'> <br> <input type='submit' name='rent' value='Rent'> </input> </form>";
    }
}

if(isset($_POST['update'])){
    $id = $_POST['facilityid'];
    header('url=mainStaff.php');
    updateFacility($id);
}

if(isset($_POST['savedInfo'])){
    savedInfo();

}

function savedInfo(){
    $id = $_POST['facilityId'];
    $name = $_POST['facilityName'];
    $price = $_POST['facilityPrice'];
    $query = mysqli_query($GLOBALS['connection'], "UPDATE facility_info SET facility_id = '$id', facility_name='$name', facility_price='$price' WHERE facility_id = '$id'");
    if($query){
        echo "<script> alert('Successfully updated'); </script>";
        findFacility($GLOBALS['connection'], $id);
    }else{
        echo "<script> alert('Failed updated'); </script>";
    }

}

function updateFacility($id){
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM `facility_info` WHERE facility_id = '$id'");
    $row = mysqli_fetch_assoc($query);
    echo "<table border='1px'>
    <tr>
        <td> <b> Facility Id </b> </td>
        <td> <b> Name of Facility </b> </td>
        <td> <b> Rented by customer <b> </td>
        <td> <b> Update <b> </td>
    </tr>";
    echo "<tr>" ;
    echo "<form method='post'><td> <input type=text value='" .$row['facility_id']. "' name='facilityId'/></td>";
    echo "<td> <input type=text value='" .$row['facility_name']. "' name='facilityName'/></td>";
    echo "<td> <input type=text value='" .$row['facility_price']. "' name='facilityPrice'/></td>";
    echo "<td>  <br> <input type='submit' name='cancel' value='Cancel'/> 
              <input type='submit' name='savedInfo' value='Save'/> </form> </td>";
    echo "</tr> </table>";

}

function findFacility($connection, $name){
    $query = mysqli_query($connection, "SELECT * FROM facility_info WHERE facility_name LIKE '$name' OR facility_id LIKE '$name'");
    if(mysqli_num_rows($query) > 0){
        echo "<table border='1px'>
        <tr>
            <td> <b> Facility Id </b> </td>
            <td> <b> Name of Facility </b> </td>
            <td> <b> Price <b> </td>
            <td> <b> Update <b> </td>
        </tr>";
        while($row = mysqli_fetch_assoc($query)){
            echo "<tr>" ;
            echo "<td> " .$row['facility_id']. "</td>";
            echo "<td> " .$row['facility_name']. "</td>";
            echo "<td> " .$row['facility_price']. "</td>";
            echo "<td> <form method='post'> <br> <input type='hidden' name='facilityid' value='".$row['facility_id']."'/> <input type='submit' name='update' value='Update'> </input> </form> </td>";
            echo "</tr>";

            //rentingProcessing($row['facility_name']);
        }
        echo "</table>";
        return true;
    }else{
        echo '<b> not found </b>';
        return false;
    }

}

function rentingProcessing($facility_name){
    echo " <form method='post'> <br> <input type='submit' name='$facility_name' value='Rent'> </input> </form>";
}
?>
<h2> Add Facility </h2>
<?php
echo "<form method='post'> <table border='1px'>
<tr>
    <td> <b> Facility Id </b> </td>
    <td> <b> Name of Facility </b> </td>
    <td> <b> Price of Facility (RM)</b> </td>
</tr>
<tr>
    <td> <b> <input type='text' name='facilityId'> </input> </b> </td>
    <td> <b> <input type='text' name='facilityName'> </input> </b> </td>
    <td> <b> <input type='text' name='facilityPrice'> </input> </b> </td>
</tr>
</table> <input type='submit' value='+' name='addF'> </input> </form>";

if(isset($_POST['addF'])){
    addFacility();
}

function addFacility(){
    $name = $_POST['facilityName'];
    $id = $_POST['facilityId'];
    $price = $_POST['facilityPrice'];
    $query = "INSERT INTO facility_info (facility_id, facility_name, facility_price) VALUES ('$id', '$name', '$price');";
    $add = mysqli_query($GLOBALS['connection'], $query);
    if($add){
        //create script code to remind if want to delete
        echo "<script> alert('Successfully added!'); </script>";
    }else{
        echo "<script> alert('Facility already exist!'); </script>";
    }
}
?>
<br>
<h2> Delete Facility </h2>
<?php
echo "<table border='1px'>
<tr>
    <td> <b> Facility Id </b> </td>
    <td> <b> Name of Facility </b> </td>
    <td> <b> Renting Price <b> </td>
    <td> <b> Delete <b> </td>
</tr>";
while($row = mysqli_fetch_assoc($facility)){
    echo "<tr>" ;
    echo "<td> " .$row['facility_id']. "</td>";
    echo "<td> " .$row['facility_name']. "</td>";
    echo "<td> " .$row['facility_price']. "</td>";
    echo "<td> <form method='post' onsubmit='return ifSure()'> <br> <input type='hidden' name='row_id' value='".$row['facility_id']."'> </input> <input type='submit' name='submitBtn' value='Delete'> </input> </form> </td>";
    echo "</tr>";

}
echo "</table>";
mysqli_data_seek($facility, 0);

if(isset($_POST['submitBtn'])){
    deleteFacility();
}

function deleteFacility(){
    $rowName = $_POST['row_id'];
    $query = "DELETE FROM facility_info WHERE facility_id = '$rowName'";
    $delete = mysqli_query($GLOBALS['connection'], $query);
    if($delete){
        //create script code to remind if want to delete
        echo "Successfully deleted row";
        header("refresh:0; url=mainStaff.php");
        exit();
    }else{
        echo "AAAAAAAAAAAAAAAA";
    }
}
mysqli_data_seek($facility, 0);
?>
<br>
<h2> Customer list </h2>
<?php
displayCustomer();

if(isset($_POST['delUser'])){
    deleteCustomer($_POST['customerId']);
}

function displayCustomer(){
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM customer_info");


    echo "<table border=1px;>
<tr>
    <td> <b>Customer ID</b> </td>
    <td> <b>Customer name</b> </td>
    <td> <b>Facility Currently Renting</b> </td>
    <td> <b>Delete User </b></td>  </tr>";


    while($row = mysqli_fetch_assoc($query)){
        echo "<form method='post' onsubmit='return ifSure()'><tr><td> ". $row['customer_id']." </td>";
        echo "<td> ". $row ['customer_name']." </td>";
        echo "<td> ". getFacilityRented($row['customer_id']). "</td> ";
        echo "<td> <input type='hidden' value='".$row['customer_id']."' name='customerId'/> <input type='submit' name='delUser' value='Delete'/> </tr> </form>";
    }
    echo "</table>";

}

function deleteCustomer($id){
    $query = mysqli_query($GLOBALS['connection'], "DELETE FROM customer_info WHERE customer_id LIKE '$id'");
    $queryFacility = mysqli_query($GLOBALS['connection'], "UPDATE facility_info SET customer_id = NULL WHERE customer_id = '$id'");
    if($query && $queryFacility){
        echo "<alert> Successfully deleted! </alert>";
        header("refresh:0; url=mainStaff.php");
    }else{
        echo "<alert> Failed to delete! </alert>";
    }
}

function getFacilityRented($id){
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM facility_info WHERE customer_id LIKE '$id'");
    $row = mysqli_fetch_assoc($query);
    if(isset($row['customer_id'])){
        mysqli_data_seek($query, 0);
        $statement = "<ol>";
        while($row = mysqli_fetch_assoc($query)){
            $statement .= "<li>". $row['facility_name']." </li>";
        }
        $statement .= "</ol>";
        return $statement;
    }else{
        return '-';
    }

}
?>
<br>
<h2> Staff list </h2>
<?php
if(isset($_POST['addStaff'])){
    addStaff();
    header('refresh:0; url=mainStaff.php');
}

if(isset($_POST['deleteStaff'])){
    deleteStaff();
    header('refresh:0; url=mainStaff.php');
}

displayStaff();

function displayStaff(){
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM staff_info");
    echo "<table border=1px;>
<tr>
    <td> <b>Staff ID</b> </td>
    <td> <b>Staff name</b> </td>
    <td> <b>Delete Staff</b> </td></tr>";
    while($row = mysqli_fetch_assoc($query)){
        echo "<tr> <b> <td> ".$row['staff_id']." </td> <td> ".$row['staff_name']." </td>
        <td> <form method='post'> <input type='hidden' value='".$row['staff_id']."' name='staffId'/>
        <input type='submit' value='delete' name='deleteStaff'/> </form></tr>";
    }
    echo "</table>";
}

function deleteStaff(){
    $id =$_POST['staffId'];
    $query = mysqli_query($GLOBALS['connection'], "DELETE FROM staff_info WHERE staff_id = '$id'");
    if($query){
        echo "<alert> Successfully deleted! </alert>";
    }else{
        echo "<alert> Failed to delete! </alert>";
    }
}

?>
<br>
<h2> Add staff </h2>
<?php
echo "<form method='post'>
Identification: <input type='text' name='staffId'> </input> <br>
Username: <input type='text' name='staffName'> </input> <br>
Password: <input type='text' name='staffPass'> </input> <br>
<input type='submit' value='Submit' name='addStaff'> </input>

</form>";



function addStaff(){
    $connection = $GLOBALS['connection'];
    $id = $_POST['staffId'];
    $name = $_POST['staffName'];
    $pass = $_POST['staffPass'];

    $query = "INSERT INTO staff_info VALUES ('$id', '$name', '$pass');";
    $add = mysqli_query($connection, $query);
    if($add){
        echo "succesfully added!";
    }else{
        echo "failed!";
    }

}

?>
<br>
<h2> Profile Setting </h2>
<?php // get profile information

?>
<form method="post"><input type="submit" value="EDIT PROFILE" name="edit"> </input> 

<input type="submit" value="LOG OUT" name="logout"> </input> </a></form>


</body>
</html>
