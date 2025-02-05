<?php
session_start();
include 'database.php';

$post_id = $_POST['post_id'];
$user_id = $_SESSION['user_id'];

// Check if the user has already liked the post
$query = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // User has already liked the post, so unlike it
  $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $post_id, $user_id);
  $stmt->execute();

  // Decrease the like count
  $query = "UPDATE posts SET liked = liked - 1 WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
} else {
  // User has not liked the post, so like it
  $query = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $post_id, $user_id);
  $stmt->execute();

  // Increase the like count
  $query = "UPDATE posts SET liked = liked + 1 WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
}

$stmt->close();
$conn->close();
?>