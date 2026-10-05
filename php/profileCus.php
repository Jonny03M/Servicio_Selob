<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $facultad = $_POST['facultad'];
    $foto = $_FILES['imagen'];

    $conn = mysqli_connect("localhost", "root", "", "selob");
    if (!empty($foto['name'])) {
        $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));
        $sql = "SELECT matricula,foto FROM imagenes WHERE matricula = '$matricula'";
        // Ejecutar la consulta SELECT
         $resultado = $conn->query($sql);
        if($resultado){ //Si encuentra registro se actualiza
            if ($resultado->num_rows > 0) {
                // Se encontraron resultados
                $sql = "UPDATE imagenes SET foto ='$imagen' WHERE matricula= '$matricula'";
                if($conn->query($sql) === TRUE){
                    $_SESSION['mensaje_'] = "bien";
                }else{
                    $_SESSION['mensaje_'] = "mal";            
                    header("Location: profileCustomize.php");
                    exit;
                }
            } else {
                //Si no hay un registro se agrega
                $sql = "INSERT INTO imagenes (matricula,foto) VALUES ('$matricula','$imagen')";
                if($conn->query($sql) === TRUE){
                    $_SESSION['mensaje_'] = "bien";
                }else{
                    $_SESSION['mensaje_'] = "mal";            
                    header("Location: profileCustomize.php");
                    exit;
                }
            }
        }else{
            $_SESSION['mensaje_'] = "mal";           
            header("Location: profileCustomize.php");
            exit;
        }     
    } 

    $sql = "UPDATE cuentasregistradas SET nombre = '$nombre',matricula='$matricula', email = '$email', contrasena = '$contrasena', facultad ='$facultad' WHERE matricula = '$matricula'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['mensaje_'] = "bien";
    }else{
        $_SESSION['mensaje_'] = "mal";           
        header("Location: profileCustomize.php");
        exit;
    }
    $conn->close();
    header("Location: profileCustomize.php");
    exit;
}
?>