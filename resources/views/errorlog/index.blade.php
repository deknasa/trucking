<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Logging Example</title>
    <script>
        // Menangkap semua error global di aplikasi
        window.onerror = function (message, source, lineno, colno, error) {
            const errorData = {
                message: message,
                source: source,
                lineno: lineno,
                colno: colno,
                stack: error ? error.stack : null
            };

            // Mengirim error ke server Laravel
            fetch('/trucking/errorlog/log-error', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(errorData)
            }).then(response => {
                if (response.ok) {
                    console.log('Error logged successfully');
                } else {
                    console.error('Failed to log error');
                }
            });

            // Supaya error tetap muncul di console browser
            return false;
        };

        // Contoh kode yang menyebabkan error
        function triggerError() {
            // Ini akan menyebabkan error karena fungsi tidak didefinisikan
            nonExistentFunction();
        }
    </script>
</head>
<body>
    <h1>Click the button to trigger an error</h1>
    <button onclick="triggerError()">Trigger Error</button>
</body>
</html>
