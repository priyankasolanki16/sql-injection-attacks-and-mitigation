<?php
require_once "db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username !== '' && $password !== '') {
    $query = "SELECT id, username, role FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "Login successful!<br>";
        echo "Username: " . htmlspecialchars($row['username']) . "<br>";
        echo "Role: " . htmlspecialchars($row['role']) . "<br>";
    } else {
        echo "Login failed.";
    }
}
?>

<h2>Vulnerable Login</h2>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>
