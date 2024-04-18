<?php
session_start();
include('connection.php');

if (!isset($_SESSION['ADMIN'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];  
    $delete_query = $con->prepare("DELETE FROM koffee WHERE id = ?");
    $delete_query->bind_param("i", $id);
    $delete_query->execute();

    if ($delete_query->affected_rows > 0) {
        header("Location: administrareconturi.php");
        echo "<p>Contul a fost șters cu succes.</p>";
    } else {
        echo "<p>Eroare la ștergerea contului.</p>";
    }
    exit;
}
$result = $con->query("SELECT id, nume, parola, utilizator FROM koffee");
$accounts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
}
$con->close();
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
                                                <span class="section-heading-lower">Administrare conturi</span>
                                            </h2>
                                            <table border="2" width="100%">
                                                <tr>
                                                    <th style="border: 2px solid black;">ID</th>
                                                    <th style="border: 2px solid black;">Nume</th>
                                                    <th style="border: 2px solid black;">Parola</th>
                                                    <th style="border: 2px solid black;">Tip</th>
                                                    <th style="border: 2px solid black;">Acțiuni</th>
                                                </tr>
                                                <?php foreach ($accounts as $account) { ?>
                                                <tr>
                                                    <td style="border: 1px solid black;"><?php echo $account['id']; ?></td>
                                                    <td style="border: 1px solid black;"><?php echo $account['nume']; ?></td>
                                                    <td style="border: 1px solid black;"><?php echo $account['parola']; ?></td>
                                                    <td style="border: 1px solid black;"><?php echo $account['utilizator']; ?></td>
                                                    <td style="border: 1px solid black;">
                                                    <a href="?delete=<?php echo $account['id']; ?>" onclick="return confirm('Ești sigur că vrei să ștergi acest cont?');">Șterge</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
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





