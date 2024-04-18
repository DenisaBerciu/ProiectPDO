<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP PROCEDURE IF EXISTS DeleteImage";
    $con->exec($sql);
    $sql = "CREATE PROCEDURE DeleteImage(IN img_id INT)
            BEGIN
                DELETE FROM imagini WHERE id = img_id;
            END;";
    $con->exec($sql);
    echo "Procedura 'DeleteImage' a fost creată cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea procedurii 'DeleteImage': " . $e->getMessage();
}
?>
