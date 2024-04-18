<?php
session_start();
require 'connection_img.php';

if (!isset($_SESSION['ADMIN'])) {
    header('Location: index.php');
    exit;
}

$image_id = isset($_GET['id']) ? $_GET['id'] : 0;
$image = null;

if ($image_id > 0) {
    $stmt = $con->prepare("SELECT id, cale_imagine FROM imagini WHERE id = ?");
    $stmt->bindParam(1, $image_id, PDO::PARAM_INT);
    $stmt->execute();
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'], $_FILES['new_image'])) {
    $numeFisier = basename($_FILES['new_image']['name']);
    $caleTemporara = $_FILES['new_image']['tmp_name'];
    $destFolder = "src/assets/img/";
    $caleDestinatie = $destFolder . $numeFisier;

    if (!file_exists($destFolder)) {
        mkdir($destFolder, 0777, true);
    }

    if (move_uploaded_file($caleTemporara, $caleDestinatie)) {
        $stmt = $con->prepare("CALL UpdateImage(?, ?)");
        $stmt->bindParam(1, $image_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $caleDestinatie, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();

        header('Location: incarcarefisiere.php');
        exit;
    } else {
        echo "<p>Eroare la mutarea fișierului în folderul de destinație.</p>";
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
        <title>Koffee - Încărcare fișiere</title>
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
                                       echo '<li><a class="dropdown-item" href="incarcarefisiere.php">Încărcare fișiere</a></li>';
                                       echo '<li><hr class="dropdown-divider" /></li>';
                                        }
                                        
                                    }
                                    echo '<li><a class="dropdown-item" href="administrareconturi.php">Administrare conturi</a></li>';
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
                                            <div class="container">
                                            <h2 class="section-heading mb-5">
                                                <span class="section-heading-lower">Editare Imagine</span>
                                            </h2>
                                                <?php if ($image): ?>
                                                    <div class="current-image">
                                                        <img src="<?php echo htmlspecialchars($image['cale_imagine']); ?>" alt="Current Image" style="width: 100px;">
                                                    </div>
                                                    <form action="update_img.php?id=<?php echo $image_id; ?>" method="post" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="new_image">Upload New Image:</label>
                                                        <input type="file" id="new_image" name="new_image" required>
                                                        <button type="submit" name="update" class="btn btn-primary">Update Image</button>
                                                    </div>
                                                </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <footer class="footer text-faded text-center py-5">
                            <div class="container"><p class="m-0 small">Copyright &copy; Koffee 2023</p></div><br>
                        </footer>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                    </body>
                    </html>
