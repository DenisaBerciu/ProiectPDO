<?php
session_start();
include('connection.php');
if (!isset($_SESSION['ADMIN'])) {
    header('location: index.php'); 
    exit;
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $image_id = $_GET['id'];
    $sql = "SELECT * FROM imagini WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $image_id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) {
        echo "Imaginea nu a fost găsită în baza de date.";
        exit;
    }
} else {
    header('location: incarcarefisiere.php'); 
    exit;
}
if (isset($_POST['submit'])) {
    if ($_FILES['cale_imagine']['size'] > 0) {
        $target = "./assets/img/" . basename($_FILES['cale_imagine']['name']);
        if (move_uploaded_file($_FILES['cale_imagine']['tmp_name'], $target)) {
            $sql1 = "UPDATE imagini SET cale_imagine=:cale_imagine WHERE id = :id";
            $stmt1 = $con->prepare($sql1);
            $stmt1->bindParam(':cale_imagine', $target, PDO::PARAM_STR);
            $stmt1->bindParam(':id', $image_id, PDO::PARAM_INT);
            if ($stmt1->execute()) {
                $_SESSION['success_message'] = "Imaginea a fost actualizată cu succes în baza de date.";
                header("location: incarcarefisiere.php");
                exit;
            } else {
                echo "Eroare la actualizarea imaginii în baza de date.";
            }
        } else {
            echo "A apărut o eroare în timpul încărcării fișierului.";
        }
    } else {
        echo "Nu s-a încărcat niciun fișier.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Koffee - Administrare conturi</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-lower">Koffee</span>
            </h1>
        </header>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.php">KOFFEE</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="index.php">Acasă</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="about.php">Despre</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="products.php">Produse</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="galerie.php">Galerie</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="menu.php">Meniu</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="store.php">Cafenea</a></li>
                        <?php 
                        if(isset($_SESSION['nume'])){
                        echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" >'.$_SESSION["nume"].'</a>';
                            echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                
                                 if(isset($_SESSION['nume'])){
                                    $pos = "";
                                    if($pos == 'admin' ){
                                       echo '<li><a class="dropdown-item" href="administrareconturi.php">Administrare conturi</a></li>';
                                       echo '<li><hr class="dropdown-divider" /></li>';
                                        }
                                        
                                    }
                                    echo '<li><a class="dropdown-item" href="incarcarefisiere.php">Încărcare fișiere</a></li>';
                                    echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                                    echo '</ul>';
                                    echo '</li>';
                                    }
                                    else{
                                        echo '<li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="login.php">Cont</a></li>';
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <section class="page-section cta">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-9 mx-auto">
                                        <div class="cta-inner bg-faded text-center rounded">
                                            <h2 class="section-heading mb-5">
                                                <span class="section-heading-lower">Editare imagine</span>
                                            </h2>
                                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $image_id; ?>" enctype="multipart/form-data">
                                            Imagine:<br><input type="file" name="cale_imagine"><br>
                                            <?php if (!empty($record['cale_imagine'])): ?>
                                                <img src="<?php echo $record['cale_imagine']; ?>" alt="Current Image" width="200"><br>
                                                <?php endif; ?>
                                                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-outline">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <footer class="footer text-faded text-center py-5">
                            <div class="container"><p class="m-0 small">Copyright &copy; Koffee 2023</p></div>
                        </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
