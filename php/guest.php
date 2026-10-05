<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombreAutor = $_POST['nombre2'];
    $correoAutor = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $matricula = $_POST['matricula'];
    $facultad = $_POST['facultad'];
    $descripcion = $_POST['descripcion'];
    
    if ( (strlen($matricula)== 9 ) and (ctype_digit($matricula)) and ((int)$matricula > 201000000) and ((int)$matricula < 202500000))  { 
        if (ctype_alpha(str_replace(' ', '', $nombre)) and (ctype_alnum(str_replace(' ', '', $facultad))) and (ctype_alnum(str_replace(' ', '', $descripcion))) and (ctype_alnum(str_replace(' ', '', $nombreAutor)))){
            if(filter_var($correoAutor,FILTER_VALIDATE_EMAIL)){
                try{
                    $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));
                }catch(Exception $e){
                    $imagen = "";
                }
    
                if($imagen != ""){
                    $conn = mysqli_connect("localhost", "root","", "selob");
                    if ($conn->connect_error) {
                        $response = array(
                         'status' => 'error',
                         'message' => '¡Hubo un error al conectarse a la base de datos!'
                        );
                    }
                    $sql = "INSERT INTO publicaciones (nombreCred, matriculaCred, facultadCred,descripcion,matriculaAutor,nombreAutor,correoAutor,foto)
                    VALUES ('$nombre', '$matricula', '$facultad','$descripcion', '$matricula', '$nombreAutor','$correoAutor','$imagen')";   
                    if($conn->query($sql) === TRUE){
                        $response = array(
                            'status' => 'success',
                            'message' => '¡El trabajo se ha realizado correctamente!'
                        );
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
                    'message' => '¡Hubo un error al ingresar el correo!'
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

}else{
    $response = array(
        'status' => 'error',
        'message' => '¡Hubo un error al procesar el formulario!'
    );
}
// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>