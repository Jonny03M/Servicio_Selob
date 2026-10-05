<!DOCTYPE html>
<html lang="en">

<head>
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/verificationDesing.css">
    <title>Document</title>
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
        }elseif($s == "delete"){ ?>
            <script>
                swal({
                        title: "¿Estás seguro?",
                        text: "Una vez eliminada, no podrás recuperar esta publicación.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((confirmed) => {
                        if (confirmed) {
                            // El usuario hizo clic en "Aceptar" (OK)
                            window.location.href = "delete.php";
                        }
                });
            </script>
        <?php
        }elseif ($s == "eliminado"){ ?>
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
        }elseif($s == "no_eliminado"){ ?>
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
        $_SESSION['mensaje_'] ="";
        ?>
    <?php
    }
    if (isset($_POST['selectedMatricula']) && isset($_POST['selectedPublication'])) {
        $publicacion = $_POST['selectedMatricula'];
        $matricula = $_POST['selectedPublication']; //Matricula que selecciono
        $_SESSION['selectedPublication'] = $matricula;
        $_SESSION['selectedMatricula'] = $publicacion;
        $conn = mysqli_connect("localhost", "root", "", "selob");
            if (!$conn) {
                echo "<script>swal('Error', 'Error al acceder a la publicación', 'error').then(function() { window.location = 'profileView.php'; });</script>";
            }
            $sql = "SELECT nombreCred,facultadCred,descripcion FROM publicaciones WHERE matriculaCred = '$matricula'";
            $resultado = mysqli_query($conn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $nombre = $fila['nombreCred'];
                    $facultad = $fila['facultadCred'];
                    $descripcion = $fila['descripcion'];
                }
            }
    } else {
        if (isset($_SESSION['selectedMatricula']) and isset($_SESSION['selectedPublication'])){
            $matricula = $_SESSION['selectedPublication'];
            $conn = mysqli_connect("localhost", "root", "", "selob");
                if (!$conn) {
                    echo "<script>swal('Error', 'Error al acceder a la publicación', 'error').then(function() { window.location = 'profileView.php'; });</script>";
                }
                $sql = "SELECT nombreCred,facultadCred,descripcion FROM publicaciones WHERE matriculaCred = '$matricula'";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $nombre = $fila['nombreCred'];
                        $facultad = $fila['facultadCred'];
                        $descripcion = $fila['descripcion'];
                    }
                }else{
                    echo "<script>swal('Error', 'No se recibieron las variables necesarias.', 'error').then(function() { window.location = 'profileView.php'; });</script>";
                }
        }else{
            echo "<script>swal('Error', 'No se recibieron las variables necesarias.', 'error').then(function() { window.location = 'profileView.php'; });</script>";       
        }        
    }
    ?>
    <!-- Navbar Start -->
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
    <div class="container card-0 justify-content-center">
        <div class="card-body px-sm-4 px-0">
            <div class="row justify-content-center mb-4">
                <div class="col-md-6 col">
                    <h3 class="font-weight-bold mx-auto text-center text-sm-left"> MODIFICAR PUBLICACIÓN </h3>
                    <p class="mt-md-2 ml-md-0 ml-2 text-center text-sm-left">INGRESE LOS DATOS DE LA CREDENCIAL QUE
                        DESEA ACTUALIZAR:</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow-lg card-1 mx-auto">
                        <div class="card-body inner-card text-center">
                            <div class="row">
                                <div class="contenedor mx-auto my-auto col-md-6">
                                    <!-- Reducimos el tamaño del box y centrar la imagen -->
                                    <img src="../imagenes/selob1.jpg" class="img-fluid rounded" alt="Imagen SELBO">
                                </div>

                                <form action="managePub.php" method="POST" enctype="multipart/form-data"
                                    class="mx-auto text-center col-md-6">
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="5" height="5" fill="currentColor"
                                            class="bi bi-person" viewBox="0 0 16 16">
                                            <!-- ... -->
                                        </svg>
                                        <label for="name">Nombre </label>
                                        <input class="form-control" type="text" name="nombreCred"
                                               value= "<?=$nombre?>" >
                                    </div>
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 8 8">
                                            <!-- ... -->
                                        </svg>
                                        <label for="matricula">Matricula</label>
                                        <input class="form-control" type="text" name="matriculaCred"
                                            value= "<?=$matricula?>" readonly>
                                    </div>
                                    <div class="form-group mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <!-- ... -->
                                        </svg>
                                        <label for="facultad">Facultad</label>
                                        <input class="form-control" type="text" name="facultadCred"
                                            value= "<?=$facultad?>" >
                                    </div>
                                    <div class="form-group mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <!-- ... -->
                                        </svg>
                                        <label for="descripcion">Descripción</label>
                                        <input class="form-control" type="text" name="descripcion"
                                            value= "<?=$descripcion?>">
                                    </div>
                                    <div class="form-group mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <!-- ... -->
                                        </svg>
                                        <label for="foto">foto</label>
                                        <input class="form-control" type="file" name="foto" placeholder="Foto"
                                            enctype="mutlipart/form-data" accept=".jpg, .png .jpeg" >
                                    </div>
                                    <div class="col-12 mt-4">
                                        <input type="hidden" name="update_action" value="update">
                                        <button type="submit" class="btn btn-primary"
                                            name="update_submit">Actualizar</button>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <input type="hidden" name="delete_action" value="delete">
                                        <button type="submit" class="btn btn-primary"
                                            name="delete_submit">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function mostrarAlerta(status, message) {
    if (status === 'success') {
        swal('Actualización correcta', message, 'success').then(function() {
            window.location = 'managePublication.php';
        });
    } else if (status === 'error') {
        swal('Error', message, 'error').then(function() {
            window.location = 'managePublication.php';
        });
    } else {
        console.error('Estado desconocido:', status);
    }
}

    </script>
</body>

</html>