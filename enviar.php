<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação básica
    $erros = [];
    
    // Validar nome
    if (empty($_POST['nome'])) {
        $erros[] = "Nome é obrigatório";
    } else {
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    }
    
    // Validar email
    if (empty($_POST['email'])) {
        $erros[] = "Email é obrigatório";
    } else {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $erros[] = "Email inválido";
        }
    }
    
    // Validar assunto e mensagem
    $assunto = filter_var($_POST['assunto'], FILTER_SANITIZE_STRING);
    $mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);
    
    if (empty($erros)) {
        $destinatario = "seuemail@dominio.com";
        $assunto_email = "Contato do Site: " . $assunto;
        
        $corpo = "Nome: $nome\n";
        $corpo .= "Email: $email\n";
        $corpo .= "Assunto: $assunto\n\n";
        $corpo .= "Mensagem:\n$mensagem\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
        
        if (mail($destinatario, $assunto_email, $corpo, $headers)) {
            header("Location: obrigado.html");
            exit;
        } else {
            $erros[] = "Erro ao enviar email";
        }
    }
    
    // Se houver erros, mostra eles
    if (!empty($erros)) {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
    }
}
?>