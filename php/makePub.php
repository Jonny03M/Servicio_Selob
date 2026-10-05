<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $matriculaAutor = $_SESSION['matricula'];
    $nombreAutor = $_SESSION['nombre'];
    $correoAutor = $_SESSION['email'];

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $facultad = $_POST['facultad'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    if ( (strlen($matricula)== 9 ) and (ctype_digit($matricula)) and ((int)$matricula > 201000000) and ((int)$matricula < 202500000))  { 
        if (ctype_alpha(str_replace(' ', '', $nombre)) and (ctype_alnum(str_replace(' ', '', $facultad))) and (ctype_alnum(str_replace(' ', '', $descripcion)))){
            try{
                $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));
            }catch(Exception $e){
                $imagen = "";
            }
            if($imagen != ""){
                $conn = mysqli_connect("localhost","root","","selob");
                if ($conn->connect_error) {
                    $response = array(
                     'status' => 'error',
                     'message' => '¡Hubo un error al conectarse a la base de datos!'
                    );
                }
                $sql = "INSERT INTO publicaciones (nombreCred, matriculaCred, facultadCred,descripcion,matriculaAutor,nombreAutor,correoAutor,foto)
                VALUES ('$nombre', '$matricula', '$facultad','$descripcion', '$matriculaAutor', '$nombreAutor','$correoAutor','$imagen')";   
                if($conn->query($sql) === TRUE){
                    $sql = "SELECT publicacion FROM cuentasregistradas WHERE matricula = '$matriculaAutor'";
                    $resultado = mysqli_query($conn, $sql);// Ejecutar la consulta

                    if (mysqli_num_rows($resultado) > 0) { // Verificar si se encontro la matricula
                        // Iterar sobre los resultados
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            $publicacion = $fila['publicacion']; // Acceder al valor del campo 'publicacion' en cada fila
                            if ($publicacion == "No Info"){
                                $publicacion = $matricula . ",";
                            }else{
                                $publicacion .= "$matricula,";
                            }
                            // Consulta SQL para actualizar el campo 'publicacion'
                            $sqlUpdate = "UPDATE cuentasregistradas SET publicacion = '$publicacion' WHERE matricula = '$matriculaAutor'";        
                            // Ejecutar la consulta de actualización
                            if (mysqli_query($conn, $sqlUpdate)) {
                                $response = array(
                                    'status' => 'success',
                                    'message' => '¡El trabajo se ha realizado correctamente!'
                                );
                            } else {
                                $response = array(
                                    'status' => 'error',
                                    'message' => '¡No se actualizo intente más tarde!'
                                );
                            }
                        }
                    }
                }
                $conn->close(); //Cerramos la conexion
            }else{
                $response = array(
                    'status' => 'error',
                    'message' => '¡Hubo un error al ingresar la fotografia!'
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'message' => '¡Hubo un error no se permiten caracteres especiales!'
            );            
        }
        
    } else {
        $response = array(
            'status' => 'error',
            'message' => '¡Hubo un error al ingresar la matricula!'
        );
    }
} else {
    // Si no se han enviado datos del formulario, enviar una respuesta de error
    $response = array(
        'status' => 'error',
        'message' => '¡Hubo un error al procesar el formulario!'
    );
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>