<?php include 'header.php'; ?>

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/carousel-1.jpg'); background-size: cover;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">¿Quiénes Somos?</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Identity and Mission Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img class="img-fluid" src="img/logo_cefi.svg" alt="Logo CEFI" style="max-height: 400px; margin: auto; display: block;">
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Identidad</h6>
                    <h1 class="mb-4">¿Quiénes somos?</h1>
                    <p class="mb-4">CEFI es un Centro Parauniversitario, fundado en 2019, respaldado por el Consejo Superior de Educación mediante el acuerdo AC-CSE-0023-03-2024.</p>
                    <p class="mb-4">Nuestra oferta académica cuenta con contenidos realmente actualizados, que se relacionan directamente al contexto nacional e internacional. CEFI tiene el compromiso de ofrecer programas que generen impactos realmente importantes y considerables a la hora de ser convertidos por los estudiantes en experiencias prácticas.</p>

                    <div class="row g-4">
                        <div class="col-sm-6">
                            <h6 class="section-title bg-white text-start text-primary pe-3">Misión</h6>
                            <p class="mb-4">Emprender y construir soluciones de formación académica con responsabilidad y valores.</p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="section-title bg-white text-start text-primary pe-3">Visión</h6>
                            <p class="mb-4">Colocar al Centro de Enseñanza y Formación Integral (CEFI) como un referente global de educación académica.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-light text-center text-primary px-3">Nuestro ADN</h6>
                <h1 class="mb-5">Nuestros Valores</h1>
            </div>
            <div class="row g-4 text-center justify-content-center">
                <?php 
                $valores = ["Excelencia académica", "Ética", "Puntualidad", "Honestidad", "Innovación", "Responsabilidad", "Respeto", "Emprendedurismo", "Transparencia"];
                foreach($valores as $index => $valor):
                    $delay = ($index * 0.1);
                ?>
                <div class="col-lg-2 col-md-4 col-6 wow zoomIn" data-wow-delay="<?php echo $delay; ?>s">
                    <div class="bg-white rounded shadow-sm p-3 h-100 d-flex align-items-center justify-content-center">
                        <h6 class="m-0 text-dark" style="font-size: 0.9rem;"><?php echo htmlspecialchars($valor); ?></h6>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Pilares Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Fundamentos</h6>
                <h1 class="mb-5">Nuestros Pilares</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex align-items-start mb-4">
                        <div class="btn-sm-square bg-primary text-white rounded-circle me-3"><i class="fa fa-sync"></i></div>
                        <div>
                            <h5 class="mb-2">Mejora Continua</h5>
                            <p class="mb-0 text-muted">Constantemente nos encontramos en la búsqueda de nuevas herramientas tecnológicas y docentes con amplia experiencia.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="btn-sm-square bg-primary text-white rounded-circle me-3"><i class="fa fa-globe"></i></div>
                        <div>
                            <h5 class="mb-2">Adaptación al cambio globalizado</h5>
                            <p class="mb-0 text-muted">CEFI se adapta a nuevos modelos eficientes en educación continua y se apoya de herramientas tecnológicas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="d-flex align-items-start mb-4">
                        <div class="btn-sm-square bg-primary text-white rounded-circle me-3"><i class="fa fa-book-open"></i></div>
                        <div>
                            <h5 class="mb-2">Programas acordes a la realidad</h5>
                            <p class="mb-0 text-muted">Los cambios y la problemática mundial es analizada e implementada por nuestros docentes semana a semana.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="btn-sm-square bg-primary text-white rounded-circle me-3"><i class="fa fa-lightbulb"></i></div>
                        <div>
                            <h5 class="mb-2">Resolución de problemas</h5>
                            <p class="mb-0 text-muted">Nuestros estudiantes desarrollan pensamiento crítico y criterio propio a través de la investigación.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advantages Start -->
    <div class="container-xxl py-5 bg-primary text-white mb-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-primary text-start text-white pe-3">Por qué elegirnos</h6>
                    <h1 class="text-white mb-4">Ventajas Competitivas</h1>
                    <div class="row g-3">
                        <?php 
                        $ventajas = ["Desarrollo profesional", "Innovación constante", "Instalaciones de nivel", "Estructura experta", "Alta calidad", "Herramientas digitales"];
                        foreach($ventajas as $v): ?>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-check text-white me-2"></i><?php echo htmlspecialchars($v); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-white rounded p-4 shadow text-dark text-center">
                        <h5 class="mb-3 text-primary"><i class="fa fa-university me-2"></i>Estructura Universitaria</h5>
                        <p class="mb-0">Nivel académico aplicado al aprendizaje sincrónico y asincrónico.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>