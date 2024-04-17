<?php
include("../includes/mysql_connect.php");
require_once("../login/classes/Login.php");

$login = new Login();

// Check if the user is logged in
if ($login->isUserLoggedIn() == false) {
    die("You need to be logged in to submit a rating.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that the required fields are set
    if (isset($_POST['id'], $_POST['rating'])) {
        $picture_id = $_POST['id'];
        $rating = $_POST['rating'];
        $user_id = $_SESSION['user_id'];

        if (!is_numeric($picture_id) || !is_numeric($rating)) {
            die("Invalid input.");
        }

        $stmt = $con->prepare("INSERT INTO communitygallery_ratings (picture_id, rater_id, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $picture_id, $user_id, $rating);

        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: ../display.php?id=$picture_id&success_message=Rating submitted successfully!");
            exit;
        } else {
            header("Location: ../display.php?id=$picture_id&error_message=Rating wasn't recorded. Please try again.");
            exit;
        }

        $stmt->close();

    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
}

?>
