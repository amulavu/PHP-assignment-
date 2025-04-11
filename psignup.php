<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "business";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$fullname = sanitize_input($_POST['fullname']);
$email = sanitize_input($_POST['email']);
$phone = sanitize_input($_POST['phone']);
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {
    die("Invalid name format.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}
if (!empty($phone) && !preg_match("/^\d{10,15}$/", $phone)) {
    die("Invalid phone format.");
}

$stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Email is already registered.");
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO customers (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    echo "Signup successful! <a href='signup.html'>Go back</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
