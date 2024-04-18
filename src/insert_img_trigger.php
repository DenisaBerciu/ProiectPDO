<?php
require_once 'connection_img.php'; 
try {
    $sql = "DROP TRIGGER IF EXISTS before_image_insert;";
    $con->exec($sql);
    
    $sql = "CREATE TRIGGER before_image_insert
            BEFORE INSERT ON imagini
            FOR EACH ROW
            BEGIN
                SET NEW.created_at = NOW();
            END;";
            
    $con->exec($sql);
    echo "Trigger-ul pentru inserare a fost creat cu succes.\n";
} catch (PDOException $e) {
    echo "Eroare la crearea trigger-ului pentru inserare: " . $e->getMessage();
}
?>
