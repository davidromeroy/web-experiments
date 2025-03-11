<?php
// Incluir el archivo de conexión
include('conexion.php');

// Recoger los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$discapacidad = $_POST['discapacidad'];
$vehiculo = $_POST['vehiculo'];
$tipoVehiculo = $_POST['tipoVehiculo'];
$foto = $_FILES['foto']['name'];  // Guardar el nombre de la foto
$entorno = $_POST['entorno'];
$musica = implode(", ", $_POST['musica']); // Convertir el array en una cadena
$ocio = implode(", ", $_POST['ocio']); // Convertir el array en una cadena
$comentarios = $_POST['comentarios'];

// Subir la foto al servidor
$fotoTemp = $_FILES['foto']['tmp_name'];
$fotoRuta = 'uploads/' . $foto;
move_uploaded_file($fotoTemp, $fotoRuta);

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellido, telefono, correo, discapacidad, vehiculo, tipoVehiculo, foto, entorno, musica, ocio, comentarios)
VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$discapacidad', '$vehiculo', '$tipoVehiculo', '$foto', '$entorno', '$musica', '$ocio', '$comentarios')"; // Este método de concatenar variables directamente dentro de la consulta SQL puede ser vulnerable a inyecciones SQL

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>