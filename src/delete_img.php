<?php
session_start();
require 'connection_img.php';
if (!isset($_SESSION['ADMIN'])) {
    header('Location: index.php');
    exit;
}
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    try {
        $stmt = $con->prepare("CALL DeleteImage(?)");
        $stmt->bindParam(1, $image_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header('Location: incarcarefisiere.php?msg=ImageDeleted');
        exit;
    } catch (PDOException $e) {
        echo "Eroare la ștergerea imaginii: " . $e->getMessage();
    }
} else {
    header('Location: incarcarefisiere.php?error=ImageIDMissing');
    exit;
}
?>
