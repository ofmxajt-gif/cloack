<?php
// Deeplink Redirect Service - omijanie przeglądarki Instagrama

// Pobierz URL z parametru
$targetUrl = $_GET['url'] ?? '';

// Jeśli nie ma URL, zakończ
if (empty($targetUrl)) {
    http_response_code(400);
    die('Brak parametru URL. Użycie: ?url=https://example.com');
}

// Walidacja URL
if (!filter_var($targetUrl, FILTER_VALIDATE_URL)) {
    die('Nieprawidłowy URL!');
}

// Lista bezpiecznych domen (można rozszerzyć)
$allowedDomains = [
    'http://', 'https://'
];

// Sprawdź czy URL zaczyna się od http/https
$urlStartsAllowed = false;
foreach ($allowedDomains as $prefix) {
    if (strpos(strtolower($targetUrl), $prefix) === 0) {
        $urlStartsAllowed = true;
        break;
    }
}

if (!$urlStartsAllowed) {
    $targetUrl = 'https://' . $targetUrl;
}

// Automatyczne przekierowanie
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przekierowywanie...</title>
    <meta http-equiv="refresh" content="0; url=<?php echo htmlspecialchars($targetUrl); ?>">
    <script>
        // Natychmiastowe przekierowanie
        window.location.href = "<?php echo htmlspecialchars($targetUrl); ?>";

        // Fallback na wypadek problemów
        setTimeout(function() {
            window.location.href = "<?php echo htmlspecialchars($targetUrl); ?>";
        }, 100);
    </script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 40px 20px;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .container {
            max-width: 400px;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="loader"></div>
        <h2>🚀 Przekierowywanie...</h2>
        <p>Zaraz zostaniesz przeniesiony/a do docelowej strony.</p>
        <p style="margin-top: 20px; font-size: 14px;">
            Jeśli przekierowanie nie działa,
            <a href="<?php echo htmlspecialchars($targetUrl); ?>">kliknij tutaj</a>
        </p>
    </div>
</body>
</html>