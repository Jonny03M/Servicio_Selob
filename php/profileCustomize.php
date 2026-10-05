<!DOCTYPE html>
<html lang="es">

<head>
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="icon" href="../imagenes/selob1.jpg">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/customizeDesing.css">
    <title>SELOB</title>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="51">
    <?php
    session_start();
    if ( isset($_SESSION['mensaje_']) ){
        $s = $_SESSION['mensaje_']; 
        if ($s == "bien"){ ?>
            <script>
                swal({
                title: "¡Buen trabajo!",
                text: "El registro ha sido actualizado correctamente",
                icon: "success",
                button: "¡Aceptar!",
            });
            </script>
        <?php
        }elseif($s == "mal") {?>
            <script>
                swal({
                title: "Error",
                text: "El registro no ha sido actualizado correctamente",
                icon: "error",
                button: "¡Aceptar!",
            });

            </script>
        <?php
        }
        $_SESSION['mensaje_']="";
    }
    // Verificar si $_SESSION['selectedPublication'] existe
    if (isset($_SESSION['selectedPublication'])) {
        $matricula = $_SESSION['selectedPublication'];
        $conn = mysqli_connect("localhost", "root", "", "selob");// Conexión a la base de datos
        if (!$conn) {// Verificar la conexión ?>
            <script>
                swal({
                title: "Error",
                text: "El registro no ha sido actualizado correctamente",
                icon: "error",
                button: "¡Aceptar!",
            });
        <?php
        }
        $sql = "SELECT nombre,email,contrasena,facultad FROM cuentasregistradas WHERE matricula= '$matricula'";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $nombre = $row['nombre'];
            $email = $row['email'];
            $contrasena = $row['contrasena'];
            $facultad = $row['facultad'];
        }
    }
    ?>
    <nav class="navbar fixed-top shadow-sm navbar-expand-lg bg-dark navbar-dark py-1 py-lg-0 px-lg-5">
        <a href="../index.html" class="navbar-brand d-block d-lg-none">
            <h1 class="display-4 text-white text-uppercase m-0">SELOB</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto py-0">
                <a href="../html/makePublication.html" class="nav-item nav-link active">PUBLICAR</a>
            </div>
            <a href="../index.html" class="navbar-brand px-4 mx-3 d-none d-lg-block">
                <h1 class="display-4 text-white text-uppercase m-0">SELOB</h1>
            </a>
            <div class="navbar-nav mr-auto py-0">
                <a href="profileView.php" class="nav-item nav-link">PERFIL</a>
            </div>
        </div>
    </nav>
</body>
<!-- Navbar End -->

<div class="container card-0 justify-content-center">
    <div class="wrapper bg-white mt-sm-5">
        <form action="profileCus.php" method="POST" enctype="multipart/form-data">
            <h4 class="pb-4 border-bottom">Editar información</h4>
            <div class="d-flex align-items-start py-3 border-bottom">
                <img src="../imagenes/camara-fotografica.png" class="img" alt="">
                <div class="pl-sm-4 pl-2" id="img-section">
                    <b>Foto de perfil</b>
                    <input type="file" name="imagen" accept=".jpg, .png, .jpeg">
                </div>
            </div>
            <div class="py-2">
                <div class="row py-2">
                    <div class="col-md-6">
                        <!-- solo que se muestre la matricula, que no se pueda cambiar-->
                        <label for="matricula">Matricula</label>
                        <input type="text" name="matricula" class="bg-light form-control" value="<?= $matricula ?>" readonly>
                        
                    </div>
                    <div class="col-md-6 pt-md-0 pt-3">
                        <label for="Nombre Apellido">Nombre</label>
                        <input type="text" name ="nombre" class="bg-light form-control" value="<?= $nombre ?>">
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-6">
                        <label for="matricula">Correo</label>
                        <input type="text" name ="email" class="bg-light form-control" value="<?= $email ?>" readonly>
                    </div>
                    <div class="col-md-6 pt-md-0 pt-3" id="lang">
                        <label for="contraseña">Contraseña</label>
                        <div class="arrow">
                            <div style="position: relative;">
                                <input type="password" class="bg-light form-control" name="contrasena" id ="contrasena"
                                    placeholder="**********" value="<?= $contrasena ?>">
                                <i class='bx bx-show-alt' style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-6">
                        <label for="facultad">Facultad</label>
                        <input type="text" class="bg-light form-control" name="facultad" value="<?= $facultad ?>">
                    </div>
                </div>
                <div class="py-3 pb-4 border-bottom">
                    <button type="submit" class="btn btn-primary mr-3">GUARDAR CAMBIOS</button>
                    <button class="btn border button"><a href="profileView.jsp">CANCELAR</button>
                </div>
            </div>
        </form>

        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const icono = document.querySelector('.bx-show-alt');
        const contraseña = document.getElementById('contrasena');

        icono.addEventListener('click', function() {
            if (contraseña.type === 'password') {
                contraseña.type = 'text';
            } else {
                contraseña.type = 'password';
            }
        });
    });
</script>
    </div>
</div>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-lg-5" style="margin-top: 65px;">
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
<div class="container-fluid bg-dark text-white text-center border-top py-4 px-sm-3 px-md-5"
    style="border-color: rgba(256, 256, 256, .05) !important;">
    <p class="m-0 text-white">&copy; <a href="#">Lusu Software</a>. Todos los Derechos Reservados. Designed by <a
            href="https://htmlcodex.com">HTML Codex</a></p>
</div>
<!-- Footer End -->


</body>

</html>