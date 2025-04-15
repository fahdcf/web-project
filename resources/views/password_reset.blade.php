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

  



    @if (request()->is('reset_password') && request()->has('validation_code'))

    @php
        $reset_email = session('reset_email');



    @endphp

    <div class="wrapper">
        <div class="reset-container">
            <div class="logo mb-5">AssignPro</div>
            <h4>Consultez votre boîte de réception !</h4>
            <p class="text-muted mb-4">
                Nous avons envoyé un lien de réinitialisation du mot de passe à <strong>{{ $reset_email }}</strong>
            </p>

            <form action="{{ url('/reset_password') }}" class="reset" method="POST">
                @csrf
                @method('PATCH')

                <div class="label">
                    <label for="entered_code" class="label">Code de verification</label>
                </div>
                <input type="number" class="form-control" placeholder="code de verification" required name="entered_code">
               
                @error('entered_code')
                <p class="alert alert-danger p-1">{{ $message }}</p>
            @enderror

                <button type="submit" class="btn btn-primary w-100">Verifier</button>
            </form>
            <div style="margin-top: 20px;">
              Vous n'avez pas de compte ?
              <a class="link" href="{{url('/signup')}}">S'inscrire</a>
          </div> 
        </div>
    </div>


    @elseif(request()->is('reset_password') && request()->has('new_password'))


    
    <div class="wrapper">
      <div class="reset-container">
          <div class="logo mb-5">AssignPro</div>
          <h4>Créez un nouveau mot de passe !</h4>
          <p class="text-muted mb-4">
            Veuillez saisir un nouveau mot de passe pour votre compte <strong> {{session('reset_email')}}</strong> 
          </p>

          <form action="{{ url('/reset_password') }}" class="reset" method="POST">
              @csrf
              @method('DELETE')

              <div class="label">
                  <label for="entered_code" class="label">Nouveau mot de passe</label>
              </div>
              <input type="password" class="form-control" placeholder="Nouveau mot de passe" required name="password">

            

          <div class="label">
            <label for="entered_code" class="label">Confirmer le mot de passe</label>
        </div>
        <input type="password" class="form-control" placeholder="Confirmer le mot de passe" required name="password_confirmation">
       
        @if ($errors->has('password'))
        <p style="font-size:13px;" class="text-center alert alert-danger mt-1 p-1">{{ $errors->first('password') }}</p>
       @endif
        

              <button type="submit" class="btn btn-primary w-100">Verifier</button>
          </form>
        
      </div>
  </div>

   
@else


      
    <div class="wrapper">
      
      <div class="reset-container">
        <div class="logo mb-5">AssignPro</div>
        <h4>Incapable de se connecter ?</h4>
        <p class="text-muted mb-4">Saisissez votre adresse e-mail et nous vous envoyons un e-mail de réinitialisation de mot de passe.</p>
      
          
            <form action="{{url('/reset_password')}}" class="reset" method="POST">
              @csrf


              
              <div class="label">
                <label for="reset_email" class="label">Adresse e-mail</label>
                 </div>
                            <input  type="email" class="form-control" placeholder="Votre adresse e-mail" required name="reset_email" value="{{old('reset_email')}}">
                      
                            
                            @error('reset_email')
                            <p class="alert alert-danger p-1">{{ $message }}</p>
                        @enderror
 
                            <button type="submit" class="btn btn-primary w-100">Continuer</button>

                            
                          </form>

                          <div style="margin-top: 20px;">
                            Vous n'avez pas de compte ?
                            <a class="link" href="{{url('/signup')}}">S'inscrire</a>
                        </div> 

            
          </div>
        </div>
        @endif
        
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
  
      .reset-container {
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
  
       .link {
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
