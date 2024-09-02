<?php
// استدعاء PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// تحميل ملفات PHPMailer
require 'C:\xampp\htdocs\codertrek\codertrek\vendor\autoload.php';

// إنشاء كائن PHPMailer
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من النموذج
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try {
        // إعدادات خادم البريد
        $mail->isSMTP();                                         // تعيين بروتوكول SMTP
        $mail->Host       = 'smtp.gmail.com';                     // تحديد خادم SMTP الذي تستخدمه
        $mail->SMTPAuth   = true;                                 // تفعيل مصادقة SMTP
        $mail->Username   = 'codertrek1@gmail.com';               // بريدك الإلكتروني
        $mail->Password   = 'ftfi tlrh skgg udye';                // كلمة المرور الخاصة ببريدك الإلكتروني
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // تمكين التشفير
        $mail->Port       = 587;                                  // رقم منفذ SMTP

        // إعدادات المستلم والمرسل
        $mail->setFrom('codertrek1@gmail.com', 'CoderTrek');      // بريد المرسل
        $mail->addAddress('recipient@example.com', 'Recipient Name'); // بريد المستلم

        // إعداد البريد للرد عليه إلى المرسل الأصلي
        $mail->addReplyTo($email, $name);

        // محتوى البريد الإلكتروني
        $mail->isHTML(true);                                      // تعيين تنسيق البريد الإلكتروني إلى HTML
        $mail->Subject = $subject;                                // عنوان البريد الإلكتروني
        $mail->Body    = "<h4>Message from: $name ($email)</h4><p>$message</p>"; // محتوى البريد
        $mail->AltBody = strip_tags($message);                    // محتوى البريد في حالة عدم دعم HTML

        // التحقق من وجود ملف مرفق
        if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK){
            $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
        }

        // إرسال البريد
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
