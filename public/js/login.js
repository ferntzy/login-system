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
