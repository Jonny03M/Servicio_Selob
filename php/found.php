<?php
session_start();
$matricula = $_SESSION['matricula'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $conexion = array("servidor"=>"Localhost","usuario"=>"root","password"=>"","db"=>"selob");
    $conn = new mysqli($conexion["servidor"],$conexion["usuario"],$conexion["password"],$conexion["db"]);
    if($conn->connect_error){
        $response = array(
            'status' => 'error',
            'message' => 'Error en la conexión a la base de datos');
        die("Fallo en la coexion");
    }else{
        $sql = "DELETE FROM publicaciones WHERE matriculaCred = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i"   , $matricula);
        if($stmt->execute()){
            // Cierre de la conexión
            $stmt->close();
            $conn->close();
            session_destroy();
            header("Location: ../index.html");
        }
        $stmt->close();
        $conn->close();
    }
}

?>