<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP TRIGGER IF EXISTS before_image_update;";
    $con->exec($sql);
    $sql = "CREATE TRIGGER before_image_update
            BEFORE UPDATE ON imagini
            FOR EACH ROW
            BEGIN
                SET NEW.updated_at = NOW();
            END;";
    $con->exec($sql);
    echo "Trigger-ul pentru actualizare a fost creat cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea trigger-ului pentru actualizare: " . $e->getMessage();
}
?>
