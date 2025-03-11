<?php
// Incluir el archivo de conexión
include('conexion.php');

// Recoger los datos del formulario y limpiar posibles caracteres maliciosos
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
$telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
$correo = mysqli_real_escape_string($conn, $_POST['correo']);
$discapacidad = mysqli_real_escape_string($conn, $_POST['discapacidad']);
$vehiculo = mysqli_real_escape_string($conn, $_POST['vehiculo']);
$tipoVehiculo = mysqli_real_escape_string($conn, $_POST['tipoVehiculo']);
$entorno = mysqli_real_escape_string($conn, $_POST['entorno']);
$musica = implode(", ", $_POST['musica']); // Convertir el array en una cadena
$ocio = implode(", ", $_POST['ocio']); // Convertir el array en una cadena
$comentarios = mysqli_real_escape_string($conn, $_POST['comentarios']);

// Subir la foto al servidor
$foto = $_FILES['foto']['name']; // Nombre del archivo
$fotoTemp = $_FILES['foto']['tmp_name']; // Ruta temporal del archivo
$fotoRuta = 'uploads/' . $foto; // Ruta donde se guardará el archivo

// Validación del archivo (por ejemplo, solo permitir imágenes JPEG y PNG)
$allowedExts = array("jpg", "jpeg", "png");
$extension = pathinfo($foto, PATHINFO_EXTENSION);

if (in_array($extension, $allowedExts)) {
    // Mover el archivo a la carpeta de destino
    if (move_uploaded_file($fotoTemp, $fotoRuta)) {
        // Preparar la consulta SQL utilizando consultas preparadas
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, telefono, correo, discapacidad, vehiculo, tipoVehiculo, foto, entorno, musica, ocio, comentarios)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $nombre, $apellido, $telefono, $correo, $discapacidad, $vehiculo, $tipoVehiculo, $foto, $entorno, $musica, $ocio, $comentarios);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al subir la foto.";
    }
} else {
    echo "Tipo de archivo no permitido. Solo se permiten imágenes JPG, JPEG o PNG.";
}

// Cerrar la conexión
$conn->close();
?>
