export default function handler(req, res) {
  const { url } = req.query;

  // Jeśli nie ma URL, zwróć błąd
  if (!url) {
    return res.status(400).json({
      error: 'Brak parametru URL. Użycie: /api/redirect?url=https://example.com'
    });
  }

  // Walidacja URL
  let targetUrl = url;

  // Dodaj https:// jeśli brakuje
  if (!targetUrl.startsWith('http://') && !targetUrl.startsWith('https://')) {
    targetUrl = 'https://' + targetUrl;
  }

  // Sprawdź czy to prawidłowy URL
  try {
    new URL(targetUrl);
  } catch (error) {
    return res.status(400).json({ error: 'Nieprawidłowy URL!' });
  }

  // Ustaw nagłówki do przekierowania
  res.setHeader('Content-Type', 'text/html; charset=UTF-8');
  res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
  res.setHeader('Pragma', 'no-cache');
  res.setHeader('Expires', '0');

  // Wyślij HTML z automatycznym przekierowaniem
  res.send(`
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przekierowywanie...</title>
    <meta http-equiv="refresh" content="0; url=${targetUrl}">
    <script>
        // Natychmiastowe przekierowanie
        window.location.href = "${targetUrl}";

        // Fallback na wypadek problemów
        setTimeout(function() {
            window.location.href = "${targetUrl}";
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
            <a href="${targetUrl}">kliknij tutaj</a>
        </p>
    </div>
</body>
</html>
  `);
}
