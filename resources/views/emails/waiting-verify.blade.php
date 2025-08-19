<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thoth Gate</title>
</head>
<body>
    <div>
        <h2>Your email is not verified</h2>
        <p>Please check your inbox and click the verification link.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>
    </div>

    <script>
        setTimeout(function() {
            window.location.reload();
        }, 3000);
    </script>

</body>
</html>
