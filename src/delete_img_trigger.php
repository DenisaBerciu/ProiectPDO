<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP TRIGGER IF EXISTS before_image_delete;";
    $con->exec($sql);
    $sql = "CREATE TRIGGER before_image_delete
            BEFORE DELETE ON imagini
            FOR EACH ROW
            BEGIN
                INSERT INTO imagini_deleted_log (image_id, deleted_at) 
                VALUES (OLD.id, NOW());
            END;";
    $con->exec($sql);
    echo "Trigger-ul pentru ștergere a fost creat cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea trigger-ului pentru ștergere: " . $e->getMessage();
}
?>
