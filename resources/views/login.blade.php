<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AssignPro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        
            @vite(['resources/css/app.css', 'resources/js/app.js'])
  

    </head>
 <body>
 
    <div class="page-wrapper">


@php
$errorShown = false;
@endphp

<div class="login-container">
    <div class="logo mb-4">AssignPro</div>
    <h4>Connectez-vous à votre compte</h4>
    <p class="text-muted mb-4">Utilisez vos identifiants</p>
  
  
  
    <div class="or-divider"><span>LOGIN</span></div>
  
            <form action="{{url('/login')}}" class="login" method="POST">
              @csrf

       

   

     <div class="label">
    <label for="login_email" class="label">Adresse e-mail</label>
     </div>
                <input  type="email" class="form-control" placeholder="Votre adresse e-mail" required name="login_email" value="{{old('login_email')}}">
             
                @if ($errors->has('login_email'))
                <p id="error" style="font-size:13px;" class="text-center alert alert-danger mt-1 p-1">{{ $errors->first('login_email') }}</p>
                  @endif

                <div class="label">
                    <label for="login_pwd" class="label">Mot de passe</label>
                 </div>
                     
            <input type="password"   class="form-control" placeholder="Votre mot de passe" required name="login_pwd">
              
            @if ($errors->has('login_pwd'))
            <p id="error" style="font-size:13px;" class="text-center alert alert-danger mt-1 p-1">{{ $errors->first('login_pwd') }}</p>
       @endif
                <button type="submit" class="btn btn-primary w-100">Continuer</button>

            </form>
            <div class="footer-text">

            <div>
                Vous n'avez pas de compte ?
                <a href="{{url('/signup')}}">S'inscrire</a>
            </div> 
            
            <a href="{{url('/reset_password')}}">Réinitialisation du mot de passe</a>
        </div>
    </div>
    

          <footer class="container footer-bottom d-flex justify-content-between align-items-center">
           <div>
               © 2025 AssignPro, Inc. All Rights Reserved.
            </div>
            <div class="locale-options">
              <span>🌍 Maroc</span>
              <span id="lang-switch" style="cursor: pointer;">🌐 Français</span>
            </div>
          </div>
        </footer>
</div>  





     


<style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff;
    }

    .login-container {
        width: 100%;
      max-width: 500px;
      margin: 60px auto;
      text-align: center;
    
    }

    .logo {
      font-size: 28px;
      font-weight: bold;
      color: #0547a9;
    }

    .google-btn {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 10px;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .or-divider {
        
      margin: 20px 0;
      margin-top: 50px;
      text-align: center;
      position: relative;
    }

    .or-divider::before, .or-divider::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 40%;
      height: 1px;
      background-color: #ccc;
    }

    .or-divider::before {
      left: 0;
    }

    .or-divider::after {
      right: 0;
    }

    .or-divider span {
      background-color: #fff;
      padding: 0 10px;
      color: #888;
    }

    .form-control {
      margin-bottom: 15px;
    }

    .label{
        text-align: start;
        padding: 5px;
        padding-left: 2px;
        font-weight: 500;
        color: #4e4e4e

    }
    .btn-primary {
      background-color: #0547a9;
      border: none;
    }

    .btn-primary:hover {
        background-color: #053379;
    }

    .footer-text {
      margin-top: 20px;
      font-size: 14px;
    }

    .footer-text a {
      color: #062c7d;
      text-decoration: none;
      margin: 0 5px;
      font-weight: 500;
    }
    
    .page-wrapper {
      display: grid;
      grid-template-rows: 1fr auto;
      min-height: 100vh;
      width: 100%;
    }
    footer {
      text-align: center;
      margin-top: 60px;
      font-size: 12px;
      color: #aaa;
      padding: 15px 0;

    }


    

    .locale-options {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }

    .locale-options i {
      font-size: 14px;
    }



  </style>

<script>
    document.getElementById('lang-switch').addEventListener('click', function () {
      // Redirect to English version
      window.location.href = "{{url('/en/login.html')}}";
    });
  </script>
  
 </body>
</html>
