    <!-- Footer Start -->
    <div class="container-fluid text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 text-white">
                    <h4 class="text-white mb-3"><img src="img/logo_cefi_blanco.svg" width="120px"></h4>
                    <h1 class="text-white">CEFI</h1>
                    <h5 class="text-white">Centro de Formación Integral</h5>
                   
                    
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <?php
                    try {
                        // Fetch top-level menu items (same logic as header)
                        $stmt_footer = $pdo->query("SELECT id_menu, title, url FROM menus WHERE parent_id IS NULL ORDER BY display_order ASC");
                        while ($menu_f = $stmt_footer->fetch()) {
                            echo '<a class="btn btn-link" href="' . htmlspecialchars($menu_f['url']) . '">' . htmlspecialchars($menu_f['title']) . '</a>';
                            
                            // If it has submenus, we can list them too or just keep top level. 
                            // Following "replica" instruction, let's add a small indent for submenus if any.
                            $stmt_sub_f = $pdo->prepare("SELECT title, url FROM menus WHERE parent_id = ? ORDER BY display_order ASC");
                            $stmt_sub_f->execute([$menu_f['id_menu']]);
                            while ($sub_f = $stmt_sub_f->fetch()) {
                                echo '<a class="btn btn-link ps-4" href="' . htmlspecialchars($sub_f['url']) . '" style="font-size: 0.9em;">- ' . htmlspecialchars($sub_f['title']) . '</a>';
                            }
                        }
                    } catch (PDOException $e) {
                        echo '<p class="text-danger">Error menú</p>';
                    }
                    ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contacto</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Guápiles, 50mts norte de la bomba EUSSE, en el Centro Educativo Valle Del Sol.</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>Teléfono: (506) 2711-1010 - WhatsApp: 8992-9180</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@ceficr.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/CEFI.COSTARICA?mibextid=ZbWKwL" target="_blank" title="Síguenos en Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social mx-1" href="https://www.instagram.com/cefi_cr?igsh=ZnNrZDRhdTB6Z3I0" target="_blank" title="Estamos en Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social mx-1" href="https://youtube.com/@ceficr?si=Prh18hZuQhWG6hdY" target="_blank" title="Estamos en Youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social mx-1" href="https://www.tiktok.com/@cefi_cr?_t=8jw1rg8zAJh&_r=1" target="_blank" title="Estamos en Tiktok">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                                <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3"><a href="graduaciones.php" style="color: inherit; text-decoration: none;">Graduaciones</a></h4>
                    <div class="row g-2 pt-2">
                        <?php
                        try {
                            // Fetch the latest 6 gallery images from any post
                            $stmt_grad_f = $pdo->query("SELECT value, id_post FROM attachments WHERE type = 'gallery_image' ORDER BY id_attachment DESC LIMIT 6");
                            $grads_f = $stmt_grad_f->fetchAll();

                            if (empty($grads_f)): ?>
                                <p class="text-muted small">No hay fotos de graduaciones aún.</p>
                            <?php else: 
                                foreach ($grads_f as $grad_img): ?>
                                    <div class="col-4">
                                        <a href="ver_graduacion.php?id=<?php echo $grad_img['id_post']; ?>">
                                            <img class="img-fluid bg-light p-1" src="../classbox/public/uploads/attachments/<?php echo $grad_img['value']; ?>" alt="Graduación" style="height: 60px; width: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                <?php endforeach; 
                            endif;
                        } catch (PDOException $e) {
                            echo '<p class="text-danger small">Error galería</p>';
                        }
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="container-fluid">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        developed by renangalvan.net - +506 87777849 - Administrado por Classbox

                      
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>