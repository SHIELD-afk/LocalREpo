<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $servername = "localhost"; 
    $username = "root";         
    $password = "Anil@2004";             
    $dbname = "contact_form";   

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully and saved in the database!";
        
        $to = "abankar717@gmail.com, goalaim0@gmail.com"; 
        $subject = "New Contact Message from $name";
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email";
        
        if (mail($to, $subject, $body, $headers)) {
            echo " Email notification sent successfully!";
        } else {
            echo " Error in sending email notification.";
        }
    } else {
        echo "Error saving message in the database: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>