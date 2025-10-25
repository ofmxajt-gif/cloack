# Deeplink Redirect Service

Serwis do omijania przeglądarki Instagrama i otwierania linków w domyślnej przeglądarce telefonu.

## 🚀 Jak to działa

1. Użytkownik wkleja docelowy URL na stronie
2. System generuje specjalny link
3. Po kliknięciu na Instagramie automatycznie przenosi do domyślnej przeglądarki

## 📱 Użycie

### Sposób 1: Przez interfejs webowy
1. Otwórz `index.php` w przeglądarce
2. Wklej link który chcesz przekierować
3. Skopiuj wygenerowany link
4. Użyj go na Instagramie

### Sposób 2: Bezpośrednie linki
```
https://twojadomena.com/index.php?url=https://docelowylink.com
```

## 🔧 Instalacja

1. Wrzuć pliki na serwer z PHP
2. Upewnij się że serwer obsługuje `header()` i `$_GET`
3. Gotowe!

## 🛡️ Bezpieczeństwo

- Walidacja URL
- Automatyczne dodanie `https://` jeśli brakuje
- Ochrona przed nieprawidłowymi linkami

## 📋 Przykład

Link do przekierowania:
```
https://twojadomena.com/index.php?url=https://youtube.com/watch?v=example
```

Po kliknięciu na Instagramie otworzy się YouTube w domyślnej przeglądarce!