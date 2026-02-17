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
                        <img src="img/logo_cefi.svg" alt="CEFI Logo" style="height: 50px;">
                        <small class="ms-3 text-white">WhatsApp +506 8992-9180</small>
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
                        <a href="" class="dropdown-item">1</a>
                        <a href="" class="dropdown-item">2</a>
                        <a href="" class="dropdown-item">3</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contacto</a>
            </div>
            <a href="https://wa.me/50689929180" class="btn btn-primary btn-whatsapp-large py-4 px-lg-5 d-none d-lg-block"><span style="position: relative; top: -10px;">whatsapp<i class="fab fa-whatsapp ms-3"></i></span></a>
        </div>
    </nav>
    <!-- Navbar End -->
