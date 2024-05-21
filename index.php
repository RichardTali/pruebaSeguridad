<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encriptar y enviar mensaje</title>
</head>
<body>
    <h2>Encriptar y enviar mensaje</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="correo">Pon tu correo:</label><br>
        <input type="email" id="correo" name="correo" required><br>
        <label for="mensaje">Mensaje:</label><br>
        <input type="text" id="mensaje" name="mensaje" required><br>
        <label for="clave">Clave:</label><br>
        <input type="text" id="clave" name="clave" required><br>
        <br>
        <input type="submit" value="Encriptar y enviar" name="submit">
    </form>

    <h2>Desencriptar y enviar mensaje</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="correo_desencriptar">Correo del destinatario:</label><br>
        <input type="email" id="correo_desencriptar" name="correo_desencriptar" required><br>
        <label for="mensaje_encriptado">Mensaje encriptado:</label><br>
        <input type="text" id="mensaje_encriptado" name="mensaje_encriptado" required><br>
        <label for="clave_desencriptar">Clave:</label><br>
        <input type="text" id="clave_desencriptar" name="clave_desencriptar" required><br>
        <br>
        <input type="submit" value="Desencriptar y enviar" name="desencriptar">
    </form>

    <?php
    // Incluye PHPMailer al principio del script
    require 'C:\xampp\htdocs\email3\PHPMailer\src\Exception.php';
    require 'C:\xampp\htdocs\email3\PHPMailer\src\PHPMailer.php';
    require 'C:\xampp\htdocs\email3\PHPMailer\src\SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Recibe el correo, mensaje y la clave del formulario
        $correo = $_POST['correo'];
        $mensaje = $_POST['mensaje'];
        $clave = $_POST['clave'];

        // Encriptar el mensaje utilizando AES-256-CBC
        $iv = '1234567890123456'; // Necesita ser de 16 bytes
        $encrypted_message = openssl_encrypt($mensaje, 'aes-256-cbc', $clave, 0, $iv);

        // Envía el mensaje encriptado por correo electrónico utilizando PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;          // Habilitar salida de depuración
            $mail->isSMTP();                                // Usar SMTP
            $mail->Host       = 'smtp.gmail.com';           // Servidor SMTP
            $mail->SMTPAuth   = true;                       // Autenticación SMTP
            $mail->Username   = 'richard46427@gmail.com';  // Nombre de usuario SMTP
            $mail->Password   = 'exsj hljc eone vncx';      // Contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;// Habilitar encriptación TLS implícita
            $mail->Port       = 465;                        // Puerto TCP

            // Destinatarios
            $mail->setFrom('richard46427@gmail.com', 'MailerPractica');
            $mail->addAddress($correo); // Añadir destinatario

            // Contenido del correo
            $mail->isHTML(true);                             // Formato HTML
            $mail->Subject = 'Mensaje Encriptado';
            $mail->Body    = 'El mensaje encriptado es: ' . $encrypted_message;
            $mail->CharSet = 'UTF-8';

            $mail->send();
            echo 'El mensaje encriptado se ha enviado correctamente a ' . $correo;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['desencriptar'])) {
        // Recibe el correo, mensaje encriptado y la clave del formulario
        $correo = $_POST['correo_desencriptar'];
        $mensaje_encriptado = $_POST['mensaje_encriptado'];
        $clave = $_POST['clave_desencriptar'];

        // Desencriptar el mensaje utilizando AES-256-CBC
        $iv = '1234567890123456'; // Necesita ser de 16 bytes
        $decrypted_message = openssl_decrypt($mensaje_encriptado, 'aes-256-cbc', $clave, 0, $iv);

        // Envía el mensaje desencriptado por correo electrónico utilizando PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;          // Habilitar salida de depuración
            $mail->isSMTP();                                // Usar SMTP
            $mail->Host       = 'smtp.gmail.com';           // Servidor SMTP
            $mail->SMTPAuth   = true;                       // Autenticación SMTP
            $mail->Username   = 'richard46427@gmail.com';  // Nombre de usuario SMTP
            $mail->Password   = 'exsj hljc eone vncx';      // Contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;// Habilitar encriptación TLS implícita
            $mail->Port       = 465;                        // Puerto TCP

            // Destinatarios
            $mail->setFrom('richard46427@gmail.com', 'MailerPractica');
            $mail->addAddress($correo); // Añadir destinatario

            // Contenido del correo
            $mail->isHTML(true);                             // Formato HTML
            $mail->Subject = 'Mensaje Desencriptado';
            $mail->Body    = 'El mensaje desencriptado es: ' . $decrypted_message;
            $mail->CharSet = 'UTF-8';

            $mail->send();
            echo 'El mensaje desencriptado se ha enviado correctamente a ' . $correo;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    ?>
</body>
</html>
