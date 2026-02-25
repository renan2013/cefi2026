<?php
include 'header.php'; // Includes db_connect.php

$id_post = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch post details
    $stmt = $pdo->prepare("SELECT title, synopsis, content FROM posts WHERE id_post = ?");
    $stmt->execute([$id_post]);
    $grad = $stmt->fetch();

    if (!$grad) {
        header('Location: graduaciones.php');
        exit;
    }

    // Fetch all attachments for this graduation
    $stmt_attach = $pdo->prepare("SELECT type, value, file_name FROM attachments WHERE id_post = ? ORDER BY id_attachment DESC");
    $stmt_attach->execute([$id_post]);
    $attachments = $stmt_attach->fetchAll();

    $gallery = array_filter($attachments, function($a) { return $a['type'] === 'gallery_image'; });
    $videos = array_filter($attachments, function($a) { return $a['type'] === 'youtube'; });

} catch (PDOException $e) {
    die("Error al cargar la galería: " . $e->getMessage());
}
?>

<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left Side: Images (Carousel + Grid) -->
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="graduaciones.php">Graduaciones</a></li>
                        <li class="breadcrumb-item active"><?php echo htmlspecialchars($grad['title']); ?></li>
                    </ol>
                </nav>

                <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($grad['title']); ?></h2>
                <p class="text-muted mb-4"><?php echo htmlspecialchars($grad['synopsis']); ?></p>

                <?php if (!empty($gallery)): ?>
                    <!-- Main Carousel -->
                    <div class="owl-carousel graduation-carousel mb-5 shadow rounded overflow-hidden">
                        <?php foreach ($gallery as $img): ?>
                            <div class="item">
                                <img src="../classbox/public/uploads/attachments/<?php echo $img['value']; ?>" class="img-fluid" alt="Graduación">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Full Grid of Images with Lightbox Support -->
                    <h3 class="mb-4">Galería de Fotos</h3>
                    <div class="row g-3 popup-gallery">
                        <?php foreach ($gallery as $img): 
                            $img_url = '../classbox/public/uploads/attachments/' . $img['value'];
                            ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="gallery-item shadow-sm rounded overflow-hidden">
                                    <a href="<?php echo $img_url; ?>" title="<?php echo htmlspecialchars($grad['title']); ?>">
                                        <img src="<?php echo $img_url; ?>" class="img-fluid w-100" style="height: 200px; object-fit: cover;" alt="Foto Graduación">
                                        <div class="gallery-overlay"><i class="fa fa-search-plus text-white fs-4"></i></div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-light p-5 text-center rounded">
                        <i class="fa fa-camera-retro fs-1 text-muted mb-3"></i>
                        <p>No hay fotos disponibles para esta graduación.</p>
                    </div>
                <?php endif; ?>

                <div class="mt-5">
                    <?php echo $grad['content']; ?>
                </div>
            </div>

            <!-- Right Side: Video Playlist (Sticky) -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-dark p-4 rounded shadow">
                        <h4 class="text-white mb-4 border-bottom border-secondary pb-2">
                            <i class="fa fa-video text-primary me-2"></i>Videos
                        </h4>
                        
                        <?php if (empty($videos)): ?>
                            <p class="text-muted small">No hay videos de esta ceremonia.</p>
                        <?php else: ?>
                            <div class="video-playlist">
                                <?php foreach ($videos as $vid): 
                                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid['value'], $match)) {
                                        $yid = $match[1];
                                    }
                                    ?>
                                    <div class="video-card mb-4">
                                        <?php if (isset($yid)): ?>
                                            <div class="ratio ratio-16x9 mb-2 rounded overflow-hidden">
                                                <iframe src="https://www.youtube.com/embed/<?php echo $yid; ?>" title="Video Graduación" allowfullscreen></iframe>
                                            </div>
                                        <?php endif; ?>
                                        <p class="small text-light mb-0"><?php echo htmlspecialchars($vid['file_name'] ?: 'Ceremonia de Graduación'); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <hr class="border-secondary">
                        <div class="d-grid gap-2">
                            <a href="https://wa.me/50689929180" class="btn btn-success" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Información de Matrícula
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.graduation-carousel .item img {
    height: 500px;
    object-fit: contain;
    background-color: #111;
}
.gallery-item {
    position: relative;
    transition: transform 0.3s ease;
}
.gallery-item:hover {
    transform: scale(1.05);
}
.gallery-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s ease;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
@media (max-width: 991px) {
    .graduation-carousel .item img { height: 350px; }
}

/* Lightbox Custom Styles */
.mfp-arrow {
    background: rgba(0,0,0,0.2) !important;
    border-radius: 50%;
    width: 60px !important;
    height: 60px !important;
    margin-top: -30px !important;
}
.mfp-arrow:before {
    border-top-width: 15px !important;
    border-bottom-width: 15px !important;
    margin-top: 15px !important;
}
.mfp-arrow-left:before { border-right-width: 20px !important; margin-left: 15px !important; }
.mfp-arrow-right:before { border-left-width: 20px !important; margin-left: 25px !important; }

.mfp-counter {
    top: 15px !important;
    right: 60px !important;
    font-family: 'Heebo', sans-serif;
    font-weight: 600;
}
.mfp-close {
    background: #2D8FE2 !important;
    color: white !important;
    opacity: 1 !important;
    width: 40px !important;
    height: 40px !important;
    line-height: 40px !important;
    margin-top: 10px;
    margin-right: 10px;
    border-radius: 50%;
}
.mfp-fullscreen {
    position: fixed;
    right: 60px;
    top: 15px;
    z-index: 1046;
    color: #FFF;
    font-size: 20px;
    cursor: pointer;
    opacity: 0.7;
}
.mfp-fullscreen:hover { opacity: 1; }
</style>

<!-- Magnific Popup JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
(function($) {
    $(document).ready(function(){
        // Initialize Carousel
        if ($.fn.owlCarousel) {
            $(".graduation-carousel").owlCarousel({
                items: 1,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                loop: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                animateOut: 'fadeOut'
            });
        }

        // Initialize Lightbox Gallery
        if ($.fn.magnificPopup) {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Cargando imagen #%curr%...',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1],
                    tPrev: 'Anterior',
                    tNext: 'Siguiente',
                    tCounter: '<span class="mfp-counter">%curr% de %total%</span>'
                },
                image: {
                    tError: '<a href="%url%">La imagen</a> no pudo ser cargada.',
                    titleSrc: function(item) {
                        return item.el.attr('title') || '';
                    }
                },
                callbacks: {
                    open: function() {
                        // Add fullscreen button on open
                        $('body').append('<div class="mfp-fullscreen" id="mfp-fs-btn" title="Pantalla Completa"><i class="fa fa-expand"></i></div>');
                        $('#mfp-fs-btn').on('click', function() {
                            if (!document.fullscreenElement) {
                                document.documentElement.requestFullscreen();
                                $(this).html('<i class="fa fa-compress"></i>');
                            } else {
                                if (document.exitFullscreen) {
                                    document.exitFullscreen();
                                    $(this).html('<i class="fa fa-expand"></i>');
                                }
                            }
                        });
                    },
                    close: function() {
                        $('#mfp-fs-btn').remove();
                        if (document.fullscreenElement) {
                            document.exitFullscreen();
                        }
                    }
                },
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function(element) {
                        return element.find('img');
                    }
                }
            });
        }
    });
})(jQuery);
</script>

<style>
.graduation-carousel .item img {
    height: 500px;
    object-fit: contain;
    background-color: #111;
}
.gallery-item {
    transition: transform 0.3s ease;
}
.gallery-item:hover {
    transform: scale(1.05);
}
.video-card p {
    font-weight: 500;
}
@media (max-width: 991px) {
    .graduation-carousel .item img { height: 350px; }
}
</style>

<script>
$(document).ready(function(){
  $(".graduation-carousel").owlCarousel({
      items: 1,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      loop: true,
      navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
      animateOut: 'fadeOut'
  });
});
</script>

<style>
.graduation-carousel .item img {
    height: 500px;
    object-fit: contain;
    background-color: #000;
}
@media (max-width: 991px) {
    .graduation-carousel .item img { height: 350px; }
}
.video-item h6 { font-weight: 600; }
</style>

<script>
$(document).ready(function(){
  $(".graduation-carousel").owlCarousel({
      items: 1,
      nav: true,
      dots: true,
      autoplay: true,
      loop: true,
      navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
      animateOut: 'fadeOut'
  });
});
</script>

<?php include 'footer.php'; ?>