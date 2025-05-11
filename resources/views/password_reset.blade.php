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

        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        
            @vite(['resources/css/app.css', 'resources/js/app.js'])
  
            


    </head>
    <body style="background-color:#4723d9;">

      <div class="container-fluid my-4">

  



    @if (request()->is('reset_password') && request()->has('validation_code'))

    @php
        $reset_email = session('reset_email');



    @endphp

<div class="row bg-white" style="max-width: 550px; margin: 0 auto; border-radius:35px;     box-shadow: 0px 3px 15px 4px #03022945;" >
      
  <div class="p-3 col-12 d-flex flex-column justify-content-center px-5">
      <h4 class="mt-3">Consultez votre boîte de réception !</h4>

            <p class="text-muted">
                Nous avons envoyé un lien de réinitialisation du mot de passe à <strong>{{ $reset_email }}</strong>
            </p>
      </div>

      <div class=" col-12 d-flex flex-column justify-content-center p-0">
        <img src="{{ asset('storage/images/receivecode.png') }}" class="img-fluid" style=" margin:0 auto" alt="Progress 1">
      </div>

      <div class="p-3 col-12 d-flex flex-column justify-content-center px-5">

            <form action="{{ url('/reset_password') }}" class="reset" method="POST">
                @csrf
                @method('PATCH')

                <div class="label">
                    <label for="entered_code" class="label">Code de verification</label>
                </div>
                <input type="number" class="form-control mt-2" placeholder="code de verification" required name="entered_code" style="background-color:#edf0f5; border:none; padding: 11px; border-radius: 8px;">
               
                @error('entered_code')
                <p class="alert alert-danger mt-2 py-2">{{ $message }} </p>
            @enderror

                <button type="submit" class="btn btn-primary w-100 mt-4" style="background-color: #4723d9; color: white; border-radius: 8px; padding: 11px;">Verifier</button>
            </form>
            <div style="margin-top: 20px;" class="w-100 text-center">
              Tu nes pas recevoire un code ?
              <a class="text-decoration-none" style="color: #4723d9; font-weight: 600;" href="{{url('/signup')}}">Renvoyer</a>
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


      
<div class="row bg-white" style="max-width: 550px; margin: 0 auto; border-radius:35px;     box-shadow: 0px 3px 15px 4px #03022945;" >
      
  <div class="p-3 col-12 d-flex flex-column justify-content-center px-5">
    
        <h4 class="pt-2">Incapable de se connecter ?</h4>
        <p class="text-muted ">Saisissez votre adresse e-mail et nous vous envoyons un e-mail de réinitialisation de mot de passe.</p>
      
          
    </div>

    <div class=" col-12 d-flex flex-column justify-content-center p-0">
      <img src="{{ asset('storage/images/sendemail.png') }}" class="img-fluid" style=" margin:0 auto" alt="Progress 1">
    </div>


    <div class="p-3 col-12 d-flex flex-column justify-content-center px-5">
      <form action="{{url('/reset_password')}}" class="reset" method="POST">
              @csrf


              
              <div class="label">
                <label for="reset_email" class="label">Adresse e-mail</label>
                 </div>
                            <input  type="email" class="form-control mt-2" placeholder="Votre adresse e-mail" required name="reset_email" value="{{old('reset_email')}}" style="background-color:#edf0f5; border:none; padding: 11px; border-radius: 8px;">
                      
                            
                            @error('reset_email')
                            <p class="alert alert-danger mt-2 py-2">{{ $message }} </p>
                            @enderror
 
                            <button type="submit" class="btn btn-primary w-100 mt-4" style="background-color: #4723d9; color: white; border-radius: 8px; padding: 11px;">Continuer</button>

                            
                          </form>

                          <div style="margin-top: 20px;" class="w-100 text-center">
                            Vous voulez ressayer ?
                            <a class="text-decoration-none" style="color: #4723d9; font-weight: 600;" href="{{url('/login')}}">Se connecter</a>
                        </div> 

            
          </div>
        </div>
        @endif
        
       
    </div>
      

  
  
  
  <style>
      body{
    font-family: 'Montserrat', 'sans-serif';
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
