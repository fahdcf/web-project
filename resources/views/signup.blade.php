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
  
<script>      
  window.addEventListener('DOMContentLoaded', () =>{
  
  
  const isSignup = localStorage.getItem('issignup') === 'true';
  
  if (isSignup) {

        wrapper.style.height = "660px";
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
        signupRadio.checked = true;
        
        if (document.getElementById("error")) {
    wrapper.style.height = (660 + 20) + "px";
    wrapper.style.marginTop= "50px";
}

    }

    else{

      if (document.getElementById("error")) {
    wrapper.style.height = (500 + 20) + "px";
}

    }
    
   

   
  
  });

 
  
  </script>

@php
$errorShown = false;
@endphp

    <div class="wrapper">
      


        <div class="title-text">
          <div class="title login">Login Form</div>
          <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
          <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
          </div>
          <div class="form-inner">

            <form action="{{url('/login')}}" class="login" method="POST">
              @csrf

              @if ($errors->has('login_pwd'))
           <p id="error" style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('login_pwd') }}</p>
      @endif

    @if ($errors->has('login_email'))
    <p id="error" style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('login_email') }}</p>
      @endif

              <div class="field">
                <input type="email" placeholder="Email Address" required name="login_email" value="{{old('login_email')}}">
              </div>
              <div class="field">
                <input type="password" placeholder="Password" required name="login_pwd">
              </div>
              <div class="pass-link"><a href="#">Forgot password?</a></div>
              <div class="field btnn">
                <div class="btn-layer"></div>
                <input type="submit" value="Login">
              </div>
              <div class="signup-link">Not a member? <a href="">Signup now</a></div>
            </form>

            <form action="{{url('/signup')}}" class="signup" method="POST">
            @csrf

         
              <div class="field">
                    <input type="text" placeholder="First Name" required name="firstname" value="{{old('firstname')}}">
                  </div>

                  @if (!$errorShown && $errors->has('firstname'))
                  <p style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('firstname') }}</p>
                  @php $errorShown = true; @endphp
              @endif

              <div class="field">
                <input type="text" placeholder="Last Name" required name="lastname" value="{{old('lastname')}}">
              </div>

                  @if (!$errorShown && $errors->has('lastname'))
             <p style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('lastname') }}</p>
              @php $errorShown = true; @endphp
                  @endif

              <div class="field">
                <input type="text" placeholder="Email Address" required name="email" value="{{ old('email') }}">
              </div>


              @if (!$errorShown && $errors->has('email'))
              <p id="error" style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('email') }}</p>
              @php $errorShown = true; @endphp
             @endif


              <div class="field">
                <input type="password" placeholder="Password" required name="password" >
              </div>


              @if (!$errorShown && $errors->has('password'))
              <p style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('password') }}</p>
              @php $errorShown = true; @endphp
             @endif


              <div class="field">
                <input type="password" placeholder="Confirm password" required name="password_confirmation">
              </div>

              @if (!$errorShown && $errors->has('password_confirmation'))
              <p style="font-size:13px;" class="text-center alert-danger mt-1">{{ $errors->first('password_confirmation') }}</p>
              @php $errorShown = true; @endphp
            @endif


              <div class="field btnn">
                <div class="btn-layer"></div>
                <input type="submit" value="Signup">
              </div>
              <div class="login-link ">Already have an account? <a href="">Login now</a></div>
            </form>
          </div>
        </div>
      </div>

      <style>
         @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
html,body{
  width: 100%;
  place-items: center;
  background: -webkit-linear-gradient(left, #003366,#004080,#0059b3
, #0073e6);
}
::selection{
  background: #1a75ff;
  color: #fff;
}
.wrapper{
    margin-top: 100px;
  overflow: hidden;
  max-width: 390px;
  height: 500px;
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
  transition: height 0.3s ease; 

}
.wrapper .title-text{
  display: flex;
  width: 200%;
}
.wrapper .title{
  width: 50%;
  font-size: 35px;
  font-weight: 600;
  text-align: center;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.wrapper .slide-controls{
  position: relative;
  display: flex;
  height: 50px;
  width: 100%;
  overflow: hidden;
  margin: 30px 0 10px 0;
  justify-content: space-between;
  border: 1px solid lightgrey;
  border-radius: 15px;
}
.slide-controls .slide{
  height: 100%;
  width: 100%;
  color: #fff;
  font-size: 18px;
  font-weight: 500;
  text-align: center;
  line-height: 48px;
  cursor: pointer;
  z-index: 1;
  transition: all 0.6s ease;
}
.slide-controls label.signup{
  color: #000;
}
.slide-controls .slider-tab{
  position: absolute;
  height: 100%;
  width: 50%;
  left: 0;
  z-index: 0;
  border-radius: 15px;
  background: -webkit-linear-gradient(left,#003366,#004080,#0059b3
, #0073e6);
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
input[type="radio"]{
  display: none;
}
#signup:checked ~ .slider-tab{
  left: 50%;
}
#signup:checked ~ label.signup{
  color: #fff;
  cursor: default;
  user-select: none;
}
#signup:checked ~ label.login{
  color: #000;
}
#login:checked ~ label.signup{
  color: #000;
}
#login:checked ~ label.login{
  cursor: default;
  user-select: none;
}
.wrapper .form-container{
  width: 100%;
  overflow: hidden;
}
.form-container .form-inner{
  display: flex;
  width: 200%;
}
.form-container .form-inner form{
  width: 50%;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.form-inner form .field{
  height: 50px;
  width: 100%;
  margin-top: 20px;
}
.form-inner form .field input{
  height: 100%;
  width: 100%;
  outline: none;
  padding-left: 15px;
  border-radius: 15px;
  border: 1px solid lightgrey;
  border-bottom-width: 2px;
  font-size: 17px;
  transition: all 0.3s ease;
}
.form-inner form .field input:focus{
  border-color: #1a75ff;
  /* box-shadow: inset 0 0 3px #fb6aae; */
}
.form-inner form .field input::placeholder{
  color: #999;
  transition: all 0.3s ease;
}
form .field input:focus::placeholder{
  color: #1a75ff;
}
.form-inner form .pass-link{
  margin-top: 5px;
}
.form-inner form .signup-link{
  text-align: center;
  margin-top: 30px;
}

.form-inner form .login-link{
  text-align: center;
  margin-top: 20px;
}
.form-inner form .pass-link a,
.form-inner form .signup-link a, .login-link a{
  color: #1a75ff;
  text-decoration: none;
}
.form-inner form .pass-link a:hover,
.form-inner form .signup-link a:hover{
  text-decoration: underline;
}
form .btnn{
  height: 50px;
  width: 100%;
  border-radius: 15px;
  position: relative;
  overflow: hidden;
}
form .btnn .btn-layer{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  background: -webkit-linear-gradient(right,#003366,#004080,#0059b3
, #0073e6);
  border-radius: 15px;
  transition: all 0.4s ease;;
}
form .btnn:hover .btn-layer{
  left: 0;
}
form .btnn input[type="submit"]{
  height: 100%;
  width: 100%;
  z-index: 1;
  position: relative;
  background: none;
  border: none;
  color: #fff;
  padding-left: 0;
  border-radius: 15px;
  font-size: 20px;
  font-weight: 500;
  cursor: pointer;
}


@media (max-width:500px){
  .wrapper .title{
    font-size: 23px;
    font-weight: 600;
  }

  .wrapper{
    width: 88%;
  }

 
}

      </style>

<script>
  

  
  const wrapper = document.querySelector(".wrapper");
    const loginText = document.querySelector(".title-text .login");
    const loginForm = document.querySelector("form.login");
    const loginBtn = document.querySelector("label.login");
    const signupBtn = document.querySelector("label.signup");
    const signupLink = document.querySelector("form .signup-link a");
    const loginLink = document.querySelector("form .login-link a");
    const loginRadio = document.getElementById("login");
    const signupRadio = document.getElementById("signup");

    signupBtn.onclick = (()=>{

  
    document.querySelector(".wrapper").style.height = "660px";


      loginForm.style.marginLeft = "-50%";
      loginText.style.marginLeft = "-50%";

      localStorage.setItem('issignup', 'true');

    });
    loginBtn.onclick = (()=>{
      document.querySelector(".wrapper").style.height="500px";

      loginForm.style.marginLeft = "0%";
      loginText.style.marginLeft = "0%";
      localStorage.setItem('issignup', 'false');

    });
    signupLink.onclick = (()=>{

      signupBtn.click();
      return false;
    });

    loginLink.onclick = (()=>{

      loginBtn.click();
      return false;
      });

</script>

    
 </body>
</html>
