<?php
// Configuración del correo
$to = "info@j-concept.com"; // Correo destino
$subject = "Nuevo mensaje desde el formulario de contacto";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar datos del formulario
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $asunto = filter_var(trim($_POST["asunto"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Verificar que los datos no estén vacíos y que el correo sea válido
    if (empty($name) || empty($email) || empty($telefono) || empty($asunto) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor complete todos los campos del formulario y use una dirección de correo válida.";
        exit;
    }

    // Crear el cuerpo del mensaje
    $email_content = "Nombre: $name\n";
    $email_content .= "Correo Electrónico: $email\n";
    $email_content .= "Asunto: $asunto\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Encabezados del correo
    $email_headers = "From: $name <$email>";

    // Intentar enviar el correo
    if (mail($to, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Gracias! Su mensaje ha sido enviado.";
    } else {
        http_response_code(500);
        echo "Oops! Algo salió mal y no pudimos enviar su mensaje.";
    }
} else {
    http_response_code(403);
    echo "Hay un problema con el envío del formulario. Inténtelo de nuevo.";
}
?>
