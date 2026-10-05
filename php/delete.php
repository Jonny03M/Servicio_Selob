<?php 
session_start();

if(isset($_SESSION['selectedPublication'])) {
    $matricula = $_SESSION['selectedPublication']; 
    $matriculaAutor = $_SESSION['selectedMatricula'];
    // Conexión a la base de datos
    $conn = mysqli_connect("localhost", "root", "", "selob");
    if (!$conn) {
        $_SESSION['mensaje_'] = "no_eliminado";
        header("Location: managePublication.php");
        exit;
    }

    // Obtener la publicación del autor
    $sql = "SELECT publicacion FROM cuentasregistradas WHERE matricula = '$matriculaAutor'";    
    $resultado = mysqli_query($conn, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $publicacion = $fila['publicacion'];
    } else {
        $_SESSION['mensaje_'] = "no_eliminado";
        header("Location: managePublication.php");
        exit;
    }

    // Eliminar la matrícula de la publicación
    $aux = $matricula.",";
    $res = str_replace($aux, "", $publicacion);

    // Actualizar la publicación del autor en la base de datos
    $sql = "UPDATE cuentasregistradas SET publicacion = '$res' WHERE matricula = '$matriculaAutor'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensaje_'] = "eliminado";
    } else {
        $_SESSION['mensaje_'] = "no_eliminado";
    }

    // Eliminar la publicación de la tabla 'publicaciones'
    $sql = "DELETE FROM publicaciones WHERE matriculaCred = '$matricula'";
    if (!mysqli_query($conn, $sql)) {
        $_SESSION['mensaje_'] = "no_eliminado";
    }
    //$_SESSION['mensaje_'] = "eliminado";
    // Cerrar conexión
    mysqli_close($conn);
} else {
    $_SESSION['mensaje_'] ="no_eliminado";
}
if($_SESSION['mensaje_'] == "eliminado"){
    header("Location: profileView.php");
}else{
    header("Location: managePublication.php");
}
exit;
?>
