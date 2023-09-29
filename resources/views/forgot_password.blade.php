<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forget Password</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/forget_password.css') }}" />
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="http://127.0.0.1:8000/img/Logo.svg" type="image/x-icon">
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Forget Password?</h1>

        <form id="forget-password">
            @csrf
            <div class="form-wrapper">
                <label for="email">Enter your email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required />
            </div>
            <br>

            <button id="calculateButton" type="submit">Send Email</button>
            <a href="{{ route('login') }}" class="link">Back</a>
        </form>
    </div>
    <!--=============== Jquery ===============-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ asset('ajax/url.js') }}"></script>
    <script src="{{ asset('ajax/change_passwords/forget_password.js') }}"></script>
</body>

</html>
