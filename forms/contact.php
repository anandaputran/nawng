<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Pastikan Anda telah mengimpor autoload.php jika menggunakan Composer
require '/xampp/htdocs/nawng/vendor/autoload.php'; // Sesuaikan path jika Anda menggunakan autoload manual

$receiving_email_address = 'nawngcreativeagency@gmail.com'; // Email penerima

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
  $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
  $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
  $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

  // Validasi email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email format';
    exit;
  }

  // Inisialisasi objek PHPMailer
  $mail = new PHPMailer(true);

  try {
    // Konfigurasi server SMTP
    $mail->isSMTP();  // Gunakan SMTP
    $mail->Host = 'smtp.gmail.com'; // Server SMTP Gmail
    $mail->SMTPAuth = true;          // Aktifkan autentikasi SMTP
    $mail->Username = 'botnawng@gmail.com'; // Alamat email Gmail Anda
    $mail->Password = 'gxus vzjl xlcy emjl'; // Password aplikasi Gmail Anda
    $mail->SMTPSecure = 'tls';        // TLS enkripsi
    $mail->Port = 587;                // Port untuk TLS

    // Penerima
    $mail->setFrom('botnawng@gmail.com', $name); // Email autentikasi sebagai pengirim
    $mail->addAddress($receiving_email_address); // Alamat penerima
    $mail->addReplyTo($email, $name); // Alamat balasan (Reply-To) dari form

    // Konten email
    $mail->isHTML(true);  // Set email format ke HTML
    $mail->Subject = $subject;
    $mail->Body    = 'Message: ' . nl2br($message);
    $mail->AltBody = 'Message: ' . $message;

    $mail->send();
    echo 'OK'; // Mengembalikan 'OK' jika sukses
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
} else {
  // Tampilkan pesan error jika metode bukan POST
  http_response_code(405);
  echo 'Method Not Allowed';
}
