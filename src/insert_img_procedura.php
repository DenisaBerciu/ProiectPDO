<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP PROCEDURE IF EXISTS AddImage";
    $con->exec($sql);
    $sql = "CREATE PROCEDURE AddImage(IN image_path VARCHAR(255))
            BEGIN
                INSERT INTO imagini (cale_imagine) VALUES (image_path);
            END;";
    $con->exec($sql);
    echo "Procedura 'AddImage' a fost creată cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea procedurii 'AddImage': " . $e->getMessage();
}
?>
