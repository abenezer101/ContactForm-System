<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // Replace 'YOUR_BOT_API_KEY' and 'YOUR_CHAT_ID' with your actual Telegram Bot API key and chat ID
    $botApiKey = '';
    $chatId = ''; // Your Telegram account ID

    $telegramApiUrl = "https://api.telegram.org/bot$botApiKey/sendMessage";
    $text = "Name:```$name```\nEmail:```$email```\n Subject:```$subject```\nMessage: ```$message```";

    $postData = array(
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'Markdown',
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($postData),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($telegramApiUrl, false, $context);

    if ($result !== false) {
        // Message sent successfully
        echo "<script>alert('Your message was sent successfully.')</script>";
    } else {
        // Message not sent, log errors and redirect to index.html
        error_log("Telegram API Error: " . print_r(error_get_last(), true));
        echo "<script>alert('Your message was not sent successfully.')</script>";
        exit();
    }
}
?>
