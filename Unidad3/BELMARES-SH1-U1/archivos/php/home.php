<?php
session_start();

// Evitar cache en el navegador para que no pueda ver la página tras cerrar sesión
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Validar que exista sesión activa
if (!isset($_SESSION['sesion'])) {
    header("Location: ../../index.html");
    exit();
}

// Asignar variables de sesión a una variable local (opcional)
$sesion = $_SESSION['sesion'];
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <title>Home</title>
    <!-- Icon of the page -->
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon" />
    <!-- Css -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/animate.css" rel="stylesheet" />
    <link href="../css/flex-slider.css" rel="stylesheet" />
    <link href="../css/fontawesome.css" rel="stylesheet" />
    <link href="../css/owl.css" rel="stylesheet" />
    <link href="../css/home.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  </head>

  <body>
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav class="main-nav">
              <!-- ***** Logo Start ***** -->
              <a href="home.php" class="logo">
                <img src="../img/index/logo.png" alt="Logo" width="100px" height="50px" />
              </a>
              <!-- ***** Logo End ***** -->
              <!-- ***** Menu Start ***** -->
              <ul class="nav">
                <li class="scroll-to-section"><a href="#top" class="active">Inicio</a></li>
                <li class="scroll-to-section"><a href="#services" style="color: #c7230e;">Servicios</a></li>
                <li class="scroll-to-section"><a href="#testimonials" style="color: #c7230e;">Colaboradores</a></li>
                <li class="perfil">
                  <a href="perfil.php" style="color: #fff;">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-person-circle"
                      viewBox="0 0 16 16"
                    >
                      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                      <path
                        fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                      />
                    </svg>
                    Mi perfil
                  </a>
                </li>
                <li class="scroll-to-section"><a href="salir.php">Cerrar Sesión</a></li>
              </ul>
              <a class="menu-trigger"><span>Menu</span></a>
              <!-- ***** Menu End ***** -->
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="swiper-container" id="top">
      <div class="slide-inner" style="background-image: url(../img/index/slide-04.jpg)">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="header-text">
                <h2>
                  Bienvenid@ <br />
                  <em><?php echo htmlspecialchars($sesion['nombre']); ?></em>
                </h2>
                <div class="div-dec"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <section class="services" id="services">
      <div class="container">
        <div class="row">
          <!-- Servicios con íconos y textos -->
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-credit-card"></i>
              <h4>Tarjetas de crédito</h4>
              <p>Obtén tu nueva tarjeta de crédito con Us Bank y aprovecha sus beneficios.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-arrow-up-short-wide"></i>
              <h4>Inversiones</h4>
              <p>En Us Bank encuentra la alternativa de inversión que se ajusta a tus preferencias.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-suitcase-medical"></i>
              <h4>Seguros</h4>
              <p>Adquiere un seguro de Us Bank para que protejas lo más importante para ti.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-car-side"></i>
              <h4>Crédito automotriz</h4>
              <p>¡Es momento de adquirir tu vehículo! Hazlo realidad con el crédito automotriz Us Bank.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-house-chimney"></i>
              <h4>Crédito hipotecario</h4>
              <p>En Us Bank te damos facilidades para que adquieras tu nuevo hogar o lo remodeles.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="service-item">
              <i class="fas fa-user"></i>
              <h4>Crédito personal</h4>
              <p>Obtén tu préstamo en línea o en cajeros Us Bank. ¡Más rápido y mucho más fácil!</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="simple-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <h4>
              Us <em>Bank</em> <br />
              tu banco de <em>confianza</em>
            </h4>
          </div>
          <div class="col-lg-7">
            <div class="buttons">
              <div class="green-button">
                <a href="#">Ver más</a>
              </div>
              <div class="orange-button">
                <a href="#">Registrarme</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="testimonials" id="testimonials">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 offset-lg-3">
            <div class="section-heading">
              <h6>Us Bank</h6>
              <h4>Acerca de nosotros</h4>
            </div>
          </div>
          <div class="col-lg-10 offset-lg-1">
            <div class="owl-testimonials owl-carousel" style="position: relative; z-index: 5;">
              <div class="item">
                <i class="fa fa-quote-left"></i>
                <p>
                  “Herramientas, habilidades y conocimientos para tomar decisiones más informadas, proteger, administrar y utilizar mejor tus recursos.”
                </p>
                <h4>¿Qué es la educación financiera?</h4>
                <span>Us Bank</span>
                <div class="right-image">
                  <img src="../img/index/testimonials-01.jpg" alt="" />
                </div>
              </div>
              <div class="item">
                <i class="fa fa-quote-left"></i>
                <p>
                  “Esta transición es importante, por lo que te recomendamos revisar este apartado con atención y ante cualquier duda, contactar a tu ejecutivo responsable.”
                </p>
                <h4>Transición de tasas Us Bank a nuevas tasas libres de riesgo</h4>
                <span>Us Bank</span>
                <div class="right-image">
                  <img src="../img/index/testimonials-02.jpg" alt="" />
                </div>
              </div>
              <div class="item">
                <i class="fa fa-quote-left"></i>
                <p>“Queremos ayudar a las personas y a las empresas a progresar desarrollando nuestra actividad de una forma responsable.”</p>
                <h4>Banca responsable</h4>
                <span>Us Bank</span>
                <div class="right-image">
                  <img src="../img/index/testimonials-03.jpg" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="partners">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/client-01.png" alt="Cliente 1" />
            </div>
          </div>
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/logo.png" alt="Logo" />
            </div>
          </div>
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/client-02.png" alt="Cliente 2" />
            </div>
          </div>
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/client-03.png" alt="Cliente 3" />
            </div>
          </div>
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/client-04.png" alt="Cliente 4" />
            </div>
          </div>
          <div class="col-lg-2 col-sm-4 col-6">
            <div class="item">
              <img src="../img/index/client-05.png" alt="Cliente 5" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <p>
              Copyright © 2022 Us Bank, Ltd. All Rights Reserved.
              <br />
              Designed by
              <a title="CSS Templates" rel="sponsored" href="">Erik Casillas Ochoa</a>
              Distributed By <a title="CSS Templates" rel="sponsored" href="">SH1-U1</a>
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/isotope.js"></script>
    <script src="../js/isotope.min.js"></script>
    <script src="../js/owl-carousel.js"></script>
    <script src="../js/swiper.js"></script>
    <script src="../js/tabs.js"></script>
    <script src="../js/video.js"></script>
    <script src="../js/custom.js"></script>
    <script>
      var interleaveOffset = 0.5;

      var swiperOptions = {
        loop: true,
        speed: 1000,
        grabCursor: true,
        watchSlidesProgress: true,
        mousewheelControl: true,
        keyboardControl: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        on: {
          progress: function () {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
              var slideProgress = swiper.slides[i].progress;
              var innerOffset = swiper.width * interleaveOffset;
              var innerTranslate = slideProgress * innerOffset;
              swiper.slides[i].querySelector(".slide-inner").style.transform =
                "translate3d(" + innerTranslate + "px, 0, 0)";
            }
          },
          touchStart: function () {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
              swiper.slides[i].style.transition = "";
            }
          },
          setTransition: function (speed) {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
              swiper.slides[i].style.transition = speed + "ms";
              swiper.slides[i].querySelector(".slide-inner").style.transition =
                speed + "ms";
            }
          },
        },
      };

      var swiper = new Swiper(".swiper-container", swiperOptions);
    </script>
  </body>
</html>
