{\rtf1\ansi\ansicpg1252\cocoartf2822
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0  <?php\
// 1. --- CONFIGURATION ---\
// IMPORTANT: Change this email address to your real recipient email\
$receiving_email = 'saisachin2609@gmail.com'; \
$subject = 'New Job Application/Query from Dwise Website';\
\
// 2. --- COLLECT FORM DATA ---\
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'N/A';\
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'N/A';\
$phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : 'N/A';\
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'N/A';\
\
// Prepare email body\
$email_body = "You have received a new consultation request/job inquiry.\\n\\n";\
$email_body .= "Name: " . $name . "\\n";\
$email_body .= "Email: " . $email . "\\n";\
$email_body .= "Phone: " . $phone . "\\n";\
$email_body .= "Career Goal/Message:\\n" . $message . "\\n";\
\
// 3. --- HANDLE FILE UPLOAD (Resume) ---\
$file_attached = false;\
$attachment_path = '';\
\
if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) \{\
    $file_tmp = $_FILES['resume']['tmp_name'];\
    $file_name = $_FILES['resume']['name'];\
    \
    // Create a temporary path for the attachment\
    // This is often required for the mail function to work with uploads\
    $attachment_path = sys_get_temp_dir() . '/' . basename($file_name);\
    if (move_uploaded_file($file_tmp, $attachment_path)) \{\
        $file_attached = true;\
    \}\
\}\
\
// 4. --- BUILD AND SEND EMAIL ---\
\
if ($file_attached) \{\
    // Function to create MIME boundary and attach file\
    $boundary = md5(time());\
    \
    $headers = "From: Dwise Site <noreply@yourdomain.com>\\r\\n";\
    $headers .= "Reply-To: " . $email . "\\r\\n";\
    $headers .= "MIME-Version: 1.0\\r\\n";\
    $headers .= "Content-Type: multipart/mixed; boundary=\\"" . $boundary . "\\"\\r\\n\\r\\n";\
\
    // Text Content Part\
    $mail_body = "--" . $boundary . "\\r\\n";\
    $mail_body .= "Content-Type: text/plain; charset=ISO-8859-1\\r\\n";\
    $mail_body .= "Content-Transfer-Encoding: base64\\r\\n\\r\\n";\
    $mail_body .= chunk_split(base64_encode($email_body));\
\
    // File Attachment Part\
    $file_size = filesize($attachment_path);\
    $handle = fopen($attachment_path, "r");\
    $content = fread($handle, $file_size);\
    fclose($handle);\
    $encoded_content = chunk_split(base64_encode($content));\
\
    $mail_body .= "--" . $boundary . "\\r\\n";\
    $mail_body .= "Content-Type: application/octet-stream; name=\\"" . $file_name . "\\"\\r\\n";\
    $mail_body .= "Content-Transfer-Encoding: base64\\r\\n";\
    $mail_body .= "Content-Disposition: attachment; filename=\\"" . $file_name . "\\"\\r\\n\\r\\n";\
    $mail_body .= $encoded_content . "\\r\\n";\
    $mail_body .= "--" . $boundary . "--";\
    \
    // Send email with attachment\
    $success = mail($receiving_email, $subject, $mail_body, $headers);\
\
\} else \{\
    // Send simple email without attachment\
    $headers = "From: Dwise Site <noreply@yourdomain.com>\\r\\n";\
    $headers .= "Reply-To: " . $email . "\\r\\n";\
    $success = mail($receiving_email, $subject, $email_body, $headers);\
\}\
\
// 5. --- CLEANUP AND REDIRECT ---\
\
// Delete temporary file\
if ($file_attached && file_exists($attachment_path)) \{\
    unlink($attachment_path);\
\}\
\
if ($success) \{\
    // Redirect on success (You should create a 'thank-you.html' page)\
    header('Location: thank-you.html'); \
    exit;\
\} else \{\
    // Redirect on failure\
    header('Location: error.html'); \
    exit;\
\}\
?>}