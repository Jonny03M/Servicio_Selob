<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta charset="UTF-8">
    <link rel="icon" href="../imagenes/selob1.jpg">
    <link rel="stylesheet" href="../css/profileDesing.css">
    <title>SELOB</title>
</head>
<body>

    <body data-spy="scroll" data-target=".navbar" data-offset="51">
        <?php
        session_start();
        if ( isset($_SESSION['mensaje_']) ){
            $s = $_SESSION['mensaje_']; 
            if($s == "eliminado"){ ?>    
                <script>
                    swal({
                        title: "¡Buen trabajo!",
                        text: "El registro ha sido eliminado correctamente",
                        icon: "success",
                        button: "¡Aceptar!"
                    }).then(function() {
                        window.location.href = "profileView.php";
                    });
                </script>
            <?php
            $_SESSION['mensaje_'] ="";
            }
        }
        
        $matricula = $_SESSION['matricula'];
        $conn = mysqli_connect("localhost", "root", "", "selob");// Conexión a la base de datos
        if (!$conn) {// Verificar la conexión
            die("Error de conexión: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM cuentasregistradas WHERE matricula= '$matricula'";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $publicacion = $row['publicacion'];
            $nombre = $row['nombre'];
            $email = $row['email'];
        }        
        $_SESSION['selectedPublication'] = $matricula;
        ?>
        <!-- Navbar Start -->
        <nav class="navbar fixed-top shadow-sm navbar-expand-lg bg-dark navbar-dark py-1 py-lg-0 px-lg-5">
            <a href="index.jsp" class="navbar-brand d-block d-lg-none">
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
    <div class="container card-0 justify-content-center">
        <div class="card p-4">
            <div class="image d-flex flex-column justify-content-center align-items-center">
                <button class="btn btn-secondary">
                    <!-- Comprobar si hay una imagen asociada sino se queda por defecto la de avatar.png-->
                    <?php
                    //Conectamos a la base de datos
                    $sql = "SELECT foto FROM imagenes WHERE matricula = '$matricula' ";
                    //Ejecutamos 
                    $resultado = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            // Verificar si la columna 'foto' tiene un valor
                            if (isset($fila['foto'])) {
                                $imagen = $fila['foto']; ?>
                                <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>" alt="" height="100" width="100">
                                <?php
                            }
                        }
                    } else { ?>
                        <img src="../imagenes/avatar.png" height="100" width="100" />
                    <?php } 
                    ?>
                </button>
                <span class="name mt-3"><?= $nombre ?></span>
                <span class="idd"> <?= $email ?> </span>
                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                    <span class="idd1"> <?= $matricula ?> </span>
                    <span><i class="fa fa-copy"></i></span>
                </div>
                <div class="d-flex mt-2">
                    <a href="profileCustomize.php"><button class="btn1 btn-dark">EDITAR PERFIL</button></a>
                </div>

                <?php
                $arreglo = [];
                if ($resultado) {
                    if ($publicacion && $publicacion!= "No info") {
                        $cadena = "";
                        for ($i = 0; $i < strlen($publicacion); $i++) {
                            if ($publicacion[$i] == ",") {
                                array_push($arreglo, $cadena);
                                $cadena = "";
                            } else {
                                $cadena .= $publicacion[$i];
                            }

                        }
                        ?>
                
                        <script>
                            function submitForm() {
                                document.getElementById("formPublications").submit();
                            }

                            function updateHiddenInputs() {
                                var selectElement = document.getElementById("publications");
                                var selectedIndex = selectElement.selectedIndex;
                                var selectedValue = selectElement.options[selectedIndex].value;
                                document.getElementById("selectedPublication").value = selectedValue;
                                document.getElementById("selectedMatricula").value = <?= $matricula ?>;
                                
                                // Mostrar u ocultar el botón según la selección del usuario
                                var button = document.getElementById("submitButton");
                                button.style.display = (selectedValue === "") ? "none" : "block";
                            }
                        </script>
                        <div class="col-md-6 pt-md-0 pt-3" id="lang">  
                            <form method="POST" id="formPublications" action="managePublication.php" onchange="updateHiddenInputs()">
                                <!-- Añadimos onchange="updateHiddenInputs()" al formulario -->
                                <select class="selection" name="publications" id="publications">
                                    <option disabled selected="">Mis Publicaciones...</option>
                                    <?php for ($i = 0; $i < count($arreglo); $i++) { ?>
                                        <option value="<?= $arreglo[$i] ?>">
                                            <?php echo "Credencial : " . $arreglo[$i] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="selectedMatricula" name="selectedMatricula" value="">
                                <!-- Campo oculto para enviar la matrícula seleccionada -->
                                <input type="hidden" id="selectedPublication" name="selectedPublication" value="">
                                <!-- Campo oculto para enviar la credencial seleccionada -->
                                <button type="button" id="submitButton" onclick="submitForm()"
                                    style="display: none;">VER</button>
                            </form>
                        </div>
                        <?php
                    }

                } else {
                    ?>
                    <div class="col-md-6 pt-md-0 pt-3" id="lang">
                        <select class="selection" name="publications" id="publications">
                            <option disabled selected="">Sin Publicaciones</option>
                            <option value="publi1">- - - - -</option>
                        </select>
                    </div>
                    <?php
                }
                $conn->close()
                    ?>
            </div>
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