<?php
require_once "db.php";

$username = trim($_GET['username'] ?? '');

if ($username !== '') {

    if (strlen($username) > 50) {
        echo "Invalid input.";
    } else {

        $stmt = $conn->prepare(
            "SELECT id, username, role, email
             FROM users
             WHERE username = ?"
        );

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . htmlspecialchars($row['id']) . "<br>";
                    echo "Username: " . htmlspecialchars($row['username']) . "<br>";
                    echo "Role: " . htmlspecialchars($row['role']) . "<br>";
                    echo "Email: " . htmlspecialchars($row['email']) . "<br><hr>";
                }
            } else {
                echo "No user found.";
            }

            $stmt->close();
        } else {
            echo "Unable to process search request.";
        }
    }
}
?>

<h2>Secure User Search</h2>

<form method="GET">
    <label>Username:</label>
    <input type="text" name="username" maxlength="50">
    <button type="submit">Search</button>
</form>
