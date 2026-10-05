<!DOCTYPE html>
<html lang="es">
    <head>
        <!--Boostrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <link rel="icon" href="../imagenes/selob1.jpg">

        <link rel="stylesheet" href="../css/verificationDesing.css">
        <title>SELOB</title>
    </head>
    <body>
    <body data-spy="scroll" data-target=".navbar" data-offset="51">
        <!-- Navbar Start -->
        <nav class="navbar fixed-top shadow-sm navbar-expand-lg bg-dark navbar-dark py-1 py-lg-0 px-lg-5">
            <a href="../index" class="navbar-brand d-block d-lg-none">
                <h1 class="display-4 text-white text-uppercase m-0">SELOB</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="../html/makePublication.html" class="nav-item nav-link active">PUBLICAR</a>
                </div>
                <a href="../index" class="navbar-brand px-4 mx-3 d-none d-lg-block">
                    <h1 class="display-4 text-white text-uppercase m-0">SELOB</h1>
                </a>
                <div class="navbar-nav mr-auto py-0">
                    <a href="profileView.php" class="nav-item nav-link">PERFIL</a>
                </div>
            </div>
        </nav>
    </body>     
    <!-- Navbar End -->
    <?php
    $conexion = array("servidor"=>"localhost","usuario"=>"root","password"=>"","bd"=>"selob");
    $conn = new mysqli($conexion["servidor"],$conexion["usuario"],$conexion["password"],$conexion["bd"]);
    if($conn->connect_error){
        die("Fallo en la conexión");
    }else{
        session_start();
        $sql = "SELECT * FROM publicaciones WHERE matriculaCred = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['matricula']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        if ($resultado && $resultado->num_rows > 0) {
            $nombrecred = $row['nombreCred'];
            $matriculacred = $row['matriculaCred'];
            $facultadcred = $row['facultadCred'];
            $descripcion = $row['descripcion'];
            $nombreAutor = $row['nombreAutor'];
            $matriculaAutor = $row['matriculaAutor'];
            $correoAutor = $row['correoAutor'];
        }               
    // Cierre de la conexión
        $stmt->close();
        $conn->close();
    }        

    ?>
    
    <div class="container card-0 justify-content-center">
        <div class="card-body px-sm-4 px-0">
            <div class="row justify-content-center mb-5">
                <div class="col-md-10 col">
                    <h3 class="font-weight-bold ml-md-0 mx-auto text-center text-sm-left">BÚSQUEDA EXITOSA</h3>
                    <p class="mt-md-4 ml-md-0 ml-2 text-center text-sm-left">LOS DATOS DE LA PERSONA QUE ENCONTRÓ TU CREDENCIAL SE MUESTRAN A CONTINUACIÓN:</p>
                </div>
            </div>
            
            <div class="row justify-content-center round">
                <!-- Cuadro único -->
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow-lg card-1">
                        <div class="card-body inner-card">
                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-sm-12">
                                    <div class="row px-3 mt-3 mb-0 border-line">
                                        <div class="form-group">
                                            <p class="text-center"> <strong>Datos de la credencial.</strong></p>
                                            <label for="first-name">Nombre</label>
                                            <p><?= $_SESSION['nombre'] ?></p>
                                            <label for="first-name">Matricula Credencial</label>
                                            <p><?= $matriculacred ?></p>
                                            <label for="first-name">Facultad</label>
                                            <p><?= $facultadcred ?></p>
                                            <label for="first-name">Descripcion</label>
                                            <p><?= $descripcion ?></p>
                                            <div><br>
                                                
                                                <div class="contenedor">
                                                    <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>" alt="" height="400" width="200">
                                                </div>
                                                <p>No se encontró ninguna imagen</p>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-12">
                                    <div class="row px-3 mt-3 mb-0 border-line">
                                        <div class="form-group text-left">
                                            <p class="text-center"> <strong>Datos de quien encontró la credencial.</strong></p>
                                            <label for="first-name">Nombre del autor</label>
                                            <p><?= $nombreAutor ?></p>
                                            <label for="first-name">Matricula</label>
                                            <p><?= $matriculaAutor ?></p>
                                            <label for="first-name">Correo</label>
                                            <p><?= $correoAutor ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Agrega -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center round mt-3">

                <div class="row justify-content-end mb-7">
                    <form action="svFound" method="GET">
                        <div class="col-lg-7 col-auto">
                        <button type="submit" class="btn btn-success btn-block ml-2"">
                            <small class="font-weight-bold">ENCONTRADA</small>
                        </button>
                        </div>
                    </form>
                    

                    <div class="col-lg-4 col-auto">
                        <a href="../index.html" class="btn mx-auto d-block">SALIR</a>
                    </div>
                </div>
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

</body>
</html>
