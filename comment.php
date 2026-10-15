
<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment = trim($_POST["comment"] ?? "");

    if ($comment === "" || strlen($comment) > 2000) {
        $message = "Please enter a comment (maximum 2000 characters).";
    } else {
        $user_id = (int) $_SESSION["user_id"];

        $stmt = $conn->prepare(
            "INSERT INTO comments (user_id, comment) VALUES (?, ?)"
        );

        $stmt->bind_param("is", $user_id, $comment);

        if ($stmt->execute()) {
            $message = "Your comment was saved successfully!";
        } else {
            $message = "Unable to save your comment. Please try again.";
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
    <title>Add Comment - COVID-19 Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>COVID-19 Information Portal</h1>
    <p>Share Your Feedback</p>
</header>

<main>
    <section>
        <h2>Add a Comment</h2>

        <?php if ($message !== ""): ?>
            <p role="status">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form action="comment.php" method="POST">
            <label for="comment">Your Comment</label>

            <textarea
                id="comment"
                name="comment"
                rows="5"
                maxlength="2000"
                required
                placeholder="Write your comment here..."
            ></textarea>

            <button type="submit">Submit Comment</button>
        </form>

        <p style="text-align:center;">
            <a href="dashboard.php">Back to Dashboard</a>
        </p>
    </section>
</main>

<footer>
    <p>&copy; 2026 COVID-19 Information Portal</p>
</footer>

</body>
</html>
