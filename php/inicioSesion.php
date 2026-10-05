<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/indexDesing.css">
    <link rel="icon" href="../imagenes/selob1.jpg">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>SELOB</title>
</head>
<body>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        $errores = false;

        if (!strstr($email, "@alumno.buap.mx")) {
            $errorEmail = "E-MAIL NO VALIDO";
            $errores = true;
            $response = array(
                'status' => 'error',
                'message' => '¡Correo no valido!'
            );
        }
        if (!$errores) {
            $conexion = array("servidor" => "localhost", "usuario" => "root", "password" => "", "bd" => "selob");
            $conn = new mysqli($conexion["servidor"], $conexion["usuario"], $conexion["password"], $conexion["bd"]);
            if ($conn->connect_error) {
                echo ".";
                echo "<script>
                swal({
                    title: 'Error',
                    text: 'Fallo en la conexión',
                    icon: 'error',
                    button: 'OK'
                    }).then(function() {
                        window.location = '../index.html'; 
                    });
              </script>";
                //die("Fallo en la conexión");
            } else {
                $sql = "SELECT * FROM cuentasregistradas WHERE email = ? AND contrasena = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $contrasena);
                if ($stmt->execute()) {
                    $resultado = $stmt->get_result();
                    $row = $resultado->fetch_assoc();
                    if ($resultado && $resultado->num_rows > 0) {
                        session_start();
                        $_SESSION['nombre'] = $row['nombre'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['matricula'] = $row['matricula'];
                        $_SESSION['publicacion'] = $row['publicacion'];
                        $_SESSION['facultad'] = $row['facultad'];

                        // Redireccionamiento
                        $sql = "SELECT * FROM publicaciones WHERE matriculaCred = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $_SESSION['matricula']);
                        $stmt->execute();
                        $resultado = $stmt->get_result();

                        // Cierre de la conexión
                        $stmt->close();
                        $conn->close();
                        if ($resultado->num_rows > 0) {
                            header("Location: ../php/verification.php");
                            exit;
                        } else {
                            header("Location: ../html/verificationFail.html");
                            exit;
                        }
                    } else {
                        echo ".";
                        echo "<script>
                            swal({
                                title: 'Error',
                                text: 'Correo electrónico o contraseña incorrectos',
                                icon: 'error',
                                button: 'OK'
                            }).then(function() {
                                window.location = '../index.html'; 
                            });
                        </script>";

                    }
                }
            }
        } else {
            echo ".";
            echo "<script>
                swal({
                    title: 'Error',
                    text: 'Correo electrónico incorrecto',
                    icon: 'error',
                    button: 'OK'
                    }).then(function() {
                        window.location = '../index.html'; 
                    });
              </script>";
            //header("Location: ../index.html");
        }
    } else {
        echo ".";
        echo "<script>
            swal({
                title: 'Error',
                text: 'Error en la conexión',
                icon: 'error',
                button: 'OK'
            }).then(function() {
                window.location = '../index.html'; 
            });
        </script>";

    }
    ?>

    <body data-spy="scroll" data-target=".navbar" data-offset="51">
        <!-- Navbar Start -->
        <nav class="navbar fixed-top shadow-sm navbar-expand-lg bg-dark navbar-dark py-1 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand d-block d-lg-none">
                <h1 class="display-4 text-white text-uppercase m-0"></h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="index.html" class="nav-item nav-link active">INICIO</a>
                </div>
                <a href="index.html" class="navbar-brand px-4 mx-3 d-none d-lg-block">
                    <h1 class="display-4 text-white bg-custom text-uppercase m-0 ">SELOB</h1>
                </a>
                <div class="navbar-nav mr-auto py-0">
                    <a href="html/guest.html" class="nav-item nav-link">INVITADO</a>
                </div>
            </div>
        </nav>
    </body>    
        <!-- Navbar End -->
            <div class="carousel-inner">
                <div class="carousel-item position-relative active" style="height: 100vh; min-height: 400px;">
                    <img class="position-absolute w-100 h-100" src="../imagenes/CU2.png" style="object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">SERVICIO DE LOCALIZACIÓN BUAP</h4>
                            <h3 class="display-2 font-secondary text-white mb-4">INICIA SESIÓN PARA COMENZAR A BUSCAR</h3>
                            <button class="btn-registro mx-auto d-block">Iniciar Sesión</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-lg-5" style="margin-top: 1px;">
          <div class="row pt-3">
              <div class="col-12 mb-3 px-4">
                  <div class="row mb-3 p-4" style="background: rgba(256, 256, 256, .05);">
                      <div class="col-md-4">
                          <div class="text-md-center">
                              <h5 class="text-primary text-uppercase mb-2" style="letter-spacing: 5px;">Localización</h5>
                              <p class="mb-4 m-md-0">Puebla,Puebla</p>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="text-md-center">
                              <h5 class="text-primary text-uppercase mb-2" style="letter-spacing: 5px;">Contactanos</h5>
                              <p class="mb-4 m-md-0">lusu@software.com</p>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="text-md-center">
                              <h5 class="text-primary text-uppercase mb-2" style="letter-spacing: 5px;">Call Us</h5>
                              <p class="m-0">+52 *********</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="container-fluid bg-dark text-white text-center border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .05) !important;">
          <p class="m-0 text-white">&copy; <a href="#">Lusu Software</a>. Todos los Derechos Reservados. Designed by <a href="https://htmlcodex.com">HTML Codex</a></p>
      </div>
      <!-- Footer End -->
      
            
<script src="js/animaciones.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>    
<script nomodule src="https://unpkg.com/ionicons"></script>

</body>
</html>

