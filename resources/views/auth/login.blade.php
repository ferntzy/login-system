<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .sso-buttons {
            margin-top: 20px;
        }
        .sso-buttons a {
            display: block;
            margin-bottom: 10px;
            color: #007bff;
            text-decoration: none;
        }
        #error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        <form id="login-form">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="sso-buttons">
            <a href="{{ route('auth.google') }}">Login with Google</a>
            <a href="{{ route('auth.facebook') }}">Login with Facebook</a>
        </div>
        <a href="{{ route('register') }}">Register</a>
        <div id="error-message"></div>
    </div>
    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    email: document.querySelector('input[name="email"]').value,
                    password: document.querySelector('input[name="password"]').value,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    document.getElementById('error-message').innerText = data.message;
                }
            });
        });
    </script>
</body>
</html>
