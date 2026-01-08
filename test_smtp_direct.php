<?php

echo "=== TEST CONNEXION SMTP DIRECT ===" . PHP_EOL;

$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_user = 'colibrilitteraire@gmail.com';
$smtp_pass = 'mjdvcctdgcmjgeda';

// Test de connexion socket
echo "1. Test connexion socket..." . PHP_EOL;
$socket = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 10);

if (!$socket) {
    echo "❌ ERREUR connexion socket: $errstr ($errno)" . PHP_EOL;
    exit(1);
}

echo "✓ Socket connecté" . PHP_EOL;

// Lire la réponse du serveur
$response = fgets($socket);
echo "   Réponse serveur: " . trim($response) . PHP_EOL;

// Dire bonjour
fwrite($socket, "EHLO localhost\r\n");
$response = '';
while ($line = fgets($socket)) {
    $response .= $line;
    if (substr($line, 3, 1) == ' ') break;
}
echo "✓ EHLO: " . trim(substr($response, 0, 100)) . "..." . PHP_EOL;

// Démarrer TLS
echo "2. Test STARTTLS..." . PHP_EOL;
fwrite($socket, "STARTTLS\r\n");
$response = fgets($socket);
echo "   Réponse: " . trim($response) . PHP_EOL;

if (strpos($response, '220') === 0) {
    echo "✓ STARTTLS accepté" . PHP_EOL;

    // Activer le chiffrement TLS
    $crypto = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

    if ($crypto) {
        echo "✓ Chiffrement TLS activé" . PHP_EOL;

        // Re-EHLO après TLS
        fwrite($socket, "EHLO localhost\r\n");
        while ($line = fgets($socket)) {
            if (substr($line, 3, 1) == ' ') break;
        }

        // Test AUTH
        echo "3. Test authentification..." . PHP_EOL;
        fwrite($socket, "AUTH LOGIN\r\n");
        $response = fgets($socket);
        echo "   Réponse AUTH: " . trim($response) . PHP_EOL;

        if (strpos($response, '334') === 0) {
            // Envoyer username
            fwrite($socket, base64_encode($smtp_user) . "\r\n");
            $response = fgets($socket);
            echo "   Réponse username: " . trim($response) . PHP_EOL;

            // Envoyer password
            fwrite($socket, base64_encode($smtp_pass) . "\r\n");
            $response = fgets($socket);
            echo "   Réponse password: " . trim($response) . PHP_EOL;

            if (strpos($response, '235') === 0) {
                echo "✅ AUTHENTIFICATION RÉUSSIE !" . PHP_EOL;
                echo "   → Le mot de passe d'application est VALIDE" . PHP_EOL;
            } else {
                echo "❌ AUTHENTIFICATION ÉCHOUÉE" . PHP_EOL;
                echo "   → Le mot de passe d'application est INCORRECT ou EXPIRÉ" . PHP_EOL;
                echo "   → Ou le compte Gmail bloque les connexions SMTP" . PHP_EOL;
            }
        }

        // Fermer proprement
        fwrite($socket, "QUIT\r\n");

    } else {
        echo "❌ Échec activation TLS" . PHP_EOL;
    }
} else {
    echo "❌ STARTTLS refusé" . PHP_EOL;
}

fclose($socket);
echo PHP_EOL . "=== FIN TEST ===" . PHP_EOL;
