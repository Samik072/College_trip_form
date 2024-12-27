<?php
$insert = false;
if (isset($_POST['name'])) {
    // Set connection variables
    $server = "localhost";
    $username = "root";
    $password = "Samik@2001";  // Replace with the password you set

    $dbname = "trip";

    // Create a database connection
    $con = new mysqli($server, $username, $password, $dbname);

    // Check for connection success
    if ($con->connect_error) {
        die("Connection to this database failed: " . $con->connect_error);
    }

    // Collect and sanitize post variables
    $name = htmlspecialchars($_POST['name']);
    $gender = htmlspecialchars($_POST['gender']);
    $age = intval($_POST['age']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);  // Ensure this is a string
    $desc = htmlspecialchars($_POST['desc']);

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO `trip` (`name`, `age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES (?, ?, ?, ?, ?, ?, current_timestamp())");
    $stmt->bind_param("sissss", $name, $age, $gender, $email, $phone, $desc);

    // Execute the query
    if ($stmt->execute()) {
        $insert = true;
    } else {
        echo "ERROR: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img class="bg" src="bg.jpg" alt="BCREC">
    <div class="container">
        <h1>Welcome to BCREC Shimla Trip Form</h1>
        <p>Enter your details and submit this form to confirm your participation in the trip.</p>
        <?php
        if ($insert == true) {
            echo "<p class='submitMsg'>Thanks for submitting your form. We are happy to see you joining us for the trip!</p>";
        }
        ?>
        <form action="index.php" method="post">
            <input type="text" name="name" id="name" placeholder="Enter your name" required>
            <input type="number" name="age" id="age" placeholder="Enter your age" required>
            <input type="text" name="gender" id="gender" placeholder="Enter your gender" required>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" required>
            <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Enter any other information here"></textarea>
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>
    <script src="index.js"></script>
</body>
</html>
