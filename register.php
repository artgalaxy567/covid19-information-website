```php
<?php
require_once "db.php";

$message = "";
$name = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Name validation using Regex
    if (!preg_match("/^[\p{L}\p{M} .'-]{2,100}$/u", $name)) {
        $message = "Please enter a valid name.";

    // Email validation
    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 100
    ) {
        $message = "Please enter a valid email address.";

    // Password validation using Regex
    } elseif (!preg_match(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z0-9@$!%*?&]{8,}$/",
        $password
    )) {
        $message = "Password must contain uppercase, lowercase, number, special character and at least 8 characters.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email is already registered.";
            $stmt->close();

        } else {
            $stmt->close();

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashedPassword
            );

            if ($stmt->execute()) {
                $message = "Registration successful!";
                $name = "";
                $email = "";
            } else {
                $message = "Registration failed. Please try again.";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>COVID-19 Information Portal</h1>
    <p>Create Your Account</p>
</header>

<main>
    <section>
        <h2>Registration Form</h2>

        <?php if ($message !== ""): ?>
            <p role="status">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                minlength="2"
                maxlength="100"
                value="<?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>"
                required
            >

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="100"
                value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required
            >

            <button type="submit">Register</button>
        </form>

        <p><a href="index.html">Back to Home</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2026 COVID-19 Information Portal</p>
</footer>

</body>
</html>
```