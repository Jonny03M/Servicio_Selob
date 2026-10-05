<?php
// Verifica si se recibieron las variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $matricula = $_SESSION['selectedPublication']; //matricula seleccionada 
    $conn = mysqli_connect("localhost", "root", "", "selob");
    if (!$conn) {
        $_SESSION['mensaje_'] = "mal";
    }

    if (isset($_POST["update_submit"])) {
        $nombreCred = $_POST['nombreCred'];
        $matriculaCred = $_POST['matriculaCred'];
        $facultadCred = $_POST['facultadCred'];
        $descripcion = $_POST['descripcion'];
        $foto = $_FILES['foto'];
        if (!empty($foto['name'])) {
            $imagen = addslashes(file_get_contents($_FILES["foto"]["tmp_name"]));
            $sql = "UPDATE publicaciones SET nombreCred = '$nombreCred', matriculaCred = '$matriculaCred', facultadCred = '$facultadCred', descripcion = '$descripcion', foto = '$imagen' WHERE matriculaCred='$matricula'"; 
        } else {
            $sql = "UPDATE publicaciones SET nombreCred = '$nombreCred',matriculaCred = '$matriculaCred', facultadCred = '$facultadCred', descripcion = '$descripcion' WHERE matriculaCred='$matricula'";            
        }
        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje_'] = "bien";
            header("Location: managePublication.php");
            exit;
        } else {
            $_SESSION['mensaje_'] = "mal";
            
            header("Location: managePublication.php");
            exit;
        }

    } elseif (isset($_POST["delete_submit"])) {   
        $_SESSION['mensaje_'] = "delete";   
        header("Location: managePublication.php");
        exit;
    } else {
    }
    $conn->close();
} else {
    $_SESSION['mensaje_'] = "mal";
    header("Location: managePublication.php");
    exit;
}
?>    
