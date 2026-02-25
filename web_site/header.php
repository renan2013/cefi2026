<?php require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>CEFI</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light shadow sticky-top p-0">
                    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                        <img src="img/logo_cefi_blanco.svg" alt="CEFI Logo" style="height: 65px;">
                        <small class="ms-3 text-white">CEFI +506 8992-9180</small>
                    </a>        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse align-items-center" id="navbarCollapse">
            <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Inicio</a>
                <a href="about.php" class="nav-item nav-link <?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>">Quienes somos</a>
                <a href="about.php" class="nav-item nav-link <?php echo ($currentPage == '') ? 'active' : ''; ?>">CEFI Virtual</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo (in_array($currentPage, ['team.php', 'testimonial.php', '404.php'])) ? 'active' : ''; ?>" data-bs-toggle="dropdown">Escuelas</a>
                    <div class="dropdown-menu fade-down m-0">
                        <?php
                        // Fetch categories from the database
                        try {
                            $stmt = $pdo->query("SELECT id_category, name FROM categories ORDER BY name ASC");
                            while ($category = $stmt->fetch()) {
                                echo '<a href="despliegue_escuelas.php?id=' . $category['id_category'] . '" class="dropdown-item">' . htmlspecialchars($category['name']) . '</a>';
                            }
                        } catch (PDOException $e) {
                            echo '<a href="#" class="dropdown-item">Error al cargar escuelas</a>';
                        }
                        ?>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contacto</a>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn btn-sm-square mx-1 text-white" href="https://www.facebook.com/CEFI.COSTARICA?mibextid=ZbWKwL" target="_blank" title="Síguenos en Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="btn btn-sm-square mx-1 text-white" href="https://www.instagram.com/cefi_cr?igsh=ZnNrZDRhdTB6Z3I0" target="_blank" title="Estamos en Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="btn btn-sm-square mx-1 text-white" href="https://youtube.com/@ceficr?si=Prh18hZuQhWG6hdY" target="_blank" title="Estamos en Youtube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a class="btn btn-sm-square mx-1 text-white" href="https://www.tiktok.com/@cefi_cr?_t=8jw1rg8zAJh&_r=1" target="_blank" title="Estamos en Tiktok">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                    </svg>
                </a>
            </div>
            <a href="https://wa.me/50689929180" class="btn btn-primary btn-whatsapp-large py-4 px-lg-5 d-none d-lg-block"><span style="position: relative; top: -10px;">whatsapp<i class="fab fa-whatsapp ms-3"></i></span></a>
        </div>
    </nav>
    <!-- Navbar End -->
