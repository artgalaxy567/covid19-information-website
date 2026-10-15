
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["user_name"] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - COVID-19 Portal</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>COVID-19 Information Portal</h1>
    <p>Your Health, Our Priority</p>
</header>

<main>
    <section class="hero">
        <h2>
            Welcome,
            <?php echo htmlspecialchars($name, ENT_QUOTES, "UTF-8"); ?>!
        </h2>

        <p>You have successfully logged in.</p>
        <p>Welcome to your COVID-19 information dashboard.</p>

        <div class="home-buttons">
            <a class="btn" href="index.html">Home</a>
            <a class="btn" href="comment.php">Add Comment</a>
            <a class="btn" href="logout.php">Logout</a>
        </div>
    </section>

    <section>
        <h2>COVID-19 Safety Tips</h2>

        <ul>
            <li>Wash your hands regularly.</li>
            <li>Cover your mouth when coughing or sneezing.</li>
            <li>Stay home when you are sick.</li>
            <li>Follow public health advice.</li>
        </ul>
    </section>
</main>

<footer>
    <p>&copy; 2026 COVID-19 Information Portal</p>
</footer>

</body>
</html>
