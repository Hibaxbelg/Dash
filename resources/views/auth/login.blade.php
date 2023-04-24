<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>login</title>

</head>

<body>

    <div id="particles-js"></div>

    <div class="container">
        @if (count($errors))
            <span class="error animated tada" id="msg" style="display: inline-block;height:auto">
                {{ $errors->first() }}
            </span>
        @endif


        <form method="POST" name="form1" class="box" onsubmit="return checkStuff()" action="{{ route('login') }}">

            @csrf
            <!-- form inputs here -->
            <h4>Esib<span>Dashboard</span></h4>
            <h5>connecter a votre compte</h5>
            <input id="email" type="text" name="email" :value="old('email')" placeholder="{{ __('Email') }}"
                autofocus>


            <span class="eye" onclick="myToggle()">
                <i id="hide1" class="fa fa-eye"></i>
                <i id="hide2" class="fa fa-eye-slash"></i>
            </span>
            <input type="password" name="password" placeholder="Mot de passe" id="pwd" autocomplete="off"
                name="password" placeholder="{{ __('Password') }}" autocomplete="current-password">

            <label>
                <input {{ old('remember') ? 'checked' : '' }} type="checkbox" name="remember">
                <span></span>
                <small class="rmb">Remember me</small>
            </label>
            <input type="submit" value="Se connecter" class="btn1">


        </form>

    </div>





    <script src="{{ asset('dist/js/particles.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/js/style.js') }}"></script>

</body>

</html>
