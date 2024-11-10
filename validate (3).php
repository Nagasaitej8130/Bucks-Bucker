<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bucks_bucker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$number = isset($_POST['number']) ? $_POST['number'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$upi = isset($_POST['UPI']) ? $_POST['UPI'] : '';

$fn_pat = '/^[a-zA-Z][a-zA-Z0-9 ]{1,30}$/';
$pwd_pat = '/^[a-zA-Z0-9@$& ]{5,20}$/';
$mob_pat = '/^\d{10}$/';
$mail_pat = '/^[A-Za-z0-9]+@[A-Za-z]+.[A-Za-z]{2,4}$/';
$flag = true;

if (empty($username)) {
    $flag = false;
    echo "Enter the First name PLEASE";
} else if (empty($number)) {
    $flag = false;
    echo "Enter the Mobile Number PLEASE";
} else if (empty($email)) {
    $flag = false;
    echo "Enter the E-Mail PLEASE";
} else if (empty($password)) {
    $flag = false;
    echo "Enter the password PLEASE";
} else if (empty($confirm_password)) {
    $flag = false;
    echo "Enter the confirm password PLEASE";
} else if (empty($dob)) {
    $flag = false;
    echo "Enter the date of birth";
} else if (empty($address)) {
    $flag = false;
    echo "Enter the address";
} else if (empty($country)) {
    $flag = false;
    echo "Enter the country";
} else if (empty($upi)) {
    $flag = false;
    echo "Enter the UPI";
} else if (preg_match($fn_pat, $username) == false) {
    $flag = false;
    echo "Please Enter First Name in Given Format";
} else if (preg_match($mob_pat, $number) == false) {
    $flag = false;
    echo "Please Enter Mobile in Given Format";
} else if (preg_match($mail_pat, $email) == false) {
    $flag = false;
    echo "Please Enter Mail in Given Format";
} else if (preg_match($pwd_pat, $_POST['password']) == false) {
    $flag = false;
    echo "Please Enter Password in Given Format";
} else if ($_POST['password'] !== $_POST['confirm_password']) {
    $flag = false;
    echo "Passwords didn't match.";
} else if ($flag == true) {
    echo "All details are valid";
    
    
    // Prepare and execute the statement
    $stmt = $conn->prepare("INSERT INTO sign_up_page(username, Mobile_number, Email, password,DOB, Address, Country,UPI_pin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $username, $number, $email, $password, $dob, $address, $country, $upi);

    if ($stmt->execute() === TRUE) {
        //echo "New record created successfully";
        // Redirect to login page after successful registration
        header("Location: loginpage.html");
        exit(); // Ensure no further code is executed after the redirect

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
