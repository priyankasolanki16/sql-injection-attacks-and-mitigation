<?php
require_once "db.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$message = '';

if ($username !== '' && $password !== '') {

    if (strlen($username) > 50 || strlen($password) > 100) {
        $message = "Invalid input.";
    } else {

        $stmt = $conn->prepare(
            "SELECT id, username, role
             FROM users
             WHERE username = ? AND password = ?"
        );

        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo "Login successful!<br>";
                echo "Username: " . htmlspecialchars($row['username']) . "<br>";
                echo "Role: " . htmlspecialchars($row['role']) . "<br>";
            } else {
                echo "Login failed.";
            }

            $stmt->close();
        } else {
            echo "Unable to process login request.";
        }
    }
}
?>

<h2>Secure Login</h2>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" maxlength="50"><br><br>

    <label>Password:</label>
    <input type="password" name="password" maxlength="100"><br><br>

    <button type="submit">Login</button>
</form>
