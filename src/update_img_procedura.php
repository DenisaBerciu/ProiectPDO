<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP PROCEDURE IF EXISTS UpdateImage";
    $con->exec($sql);
    $sql = "CREATE PROCEDURE UpdateImage(IN img_id INT, IN new_path VARCHAR(255))
            BEGIN
                UPDATE imagini SET cale_imagine = new_path WHERE id = img_id;
            END;";
    $con->exec($sql);
    echo "Procedura 'UpdateImage' a fost creată cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea procedurii 'UpdateImage': " . $e->getMessage();
}
?>
