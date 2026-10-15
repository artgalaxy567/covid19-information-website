<?php
session_start();
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 100 ||
        $password === ""
    ) {
        $message = "Please enter a valid email and password.";
    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            $stmt->close();

            header("Location: dashboard.php");
            exit;

        } else {
            $message = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - COVID-19 Information Portal</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>COVID-19 Information Portal</h1>
    <p>Login to Your Account</p>
</header>

<main>
    <section>
        <h2>Login Form</h2>

        <?php if ($message !== ""): ?>
            <p role="alert">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="POST">

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="100"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <button type="submit">Login</button>

        </form>

        <p style="text-align: center;">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>

        <p style="text-align: center; margin-top: 10px;">
            <a href="index.html">Back to Home</a>
        </p>
    </section>
</main>

<footer>
    <p>&copy; 2026 COVID-19 Information Portal</p>
</footer>

</body>
</html>
