<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AssignPro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


        
            @vite(['resources/css/app.css', 'resources/js/app.js'])
  

    </head>
 <body style="background-color:#4723d9;">
  <div class="container-fluid" style="margin-top:100px" >

    <div class="row bg-white" style="max-width: 1000px; margin: 0 auto; border-radius:35px;     box-shadow: 0px 3px 15px 4px #03022945;" >
  
      <!-- Left: Form Section -->
      <div class="p-3 col-md-6 d-flex flex-column justify-content-center px-5">
        
        <div class="mb-4">
          <h2 class=" fw-bold text-center" style="color: #4723d9">AssignPro</h2>
        </div>
  
      
          <h3 style="font-weight: 700" class="text-center mb-5">Login</h3>
         
  
        <form action="{{ url('/login') }}" method="POST">
          @csrf
  
          <div class="my-3">
            <label for="login_email" class="form-label">Adresse e-mail</label>
            <input type="email" name="login_email" class="form-control " placeholder="Votre adresse e-mail" value="{{ old('login_email') }}" required style="background-color:#edf0f5; border:none; padding: 11px; border-radius: 8px;">
            @if ($errors->has('login_email'))
              <small class="text-danger">{{ $errors->first('login_email') }}</small>
            @endif
          </div>
  
          <div class="mb-3">
            <label for="login_pwd" class="form-label">Mot de passe</label>
            <input  type="password" name="login_pwd" class="form-control " placeholder="Votre mot de passe" required style="background-color:#edf0f5; border:none; padding: 11px; border-radius: 8px;">
            @if ($errors->has('login_pwd'))
              <small class="text-danger">{{ $errors->first('login_pwd') }}</small>
            @endif
          </div>
  
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Se souvenir de moi</label>
          </div>


          <button type="submit" class="btn  w-100 py-2  " style="background-color: #4723d9; color: white; border-radius: 8px; padding: 11px;">Continuer</button>
        
          <div class="text-center mt-3">
            <a href="{{ url('/reset_password') }}" class="text-decoration-none" style="color: #4723d9; font-weight: 600;">Réinitialisation du mot de passe</a>
          </div>
        </form>
      </div>

 <!-- Right: Image Section (Auto-Sliding Carousel with No Controls) -->
<div class="col-md-6 d-none d-md-flex bg-light align-items-center justify-content-center" style="border-top-right-radius: 35px;border-bottom-right-radius: 35px; padding: 20px;">
  <div id="carouselExample" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner text-center px-4 mb-5">
      <!-- Carousel Items -->
      <div class="carousel-item active" style="height: 450px">
        <img src="{{ asset('storage/images/dashboarlogin.gif') }}" class="img-fluid mb-4" style="max-width: 70%; margin:0 auto" alt="Progress 1">
        <h5 class="fw-bold">Suivez tout depuis le tableau de bord</h5>
        <p class="text-muted">Visualisez en temps réel les affectations, les charges horaires, les souhaits des enseignants et les modules vacants.</p>
      </div>

      <div class="carousel-item " style="height: 450px">
        <img src="{{ asset('storage/images/departementlogin.gif') }}" class="img-fluid mb-4" style="max-width: 70%; margin: 0 auto" alt="Progress 2">
        <h5 class="fw-bold">Gérez vos départements facilement</h5>
        <p class="text-muted">Centralisez la gestion des unités d’enseignement, des enseignants et des vacataires selon les spécialités.</p>
      </div>

      <div class="carousel-item " style="height: 450px">
        <img src="{{ asset('storage/images/professorslogin.gif') }}" class="img-fluid mb-4" style="max-width: 70%; margin:0 auto" alt="Progress 3">
        <h5 class="fw-bold">Offrez plus d’autonomie aux enseignants</h5>
        <p class="text-muted">Permettez aux enseignants d’exprimer leurs souhaits et aux coordonnateurs d’organiser les groupes et les emplois du temps.</p>
      </div>
    </div>

    <!-- Carousel Indicators -->
    <div class="carousel-indicators mt-5">
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" style="background-color: #4723d9;"></button>
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" style="background-color: #4723d9;"></button>
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" style="background-color: #4723d9;"></button>
    </div>
  </div>
</div>


    </div>

  </div>
  




     
<style>
  body{
    font-family: 'Montserrat', 'sans-serif';
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
