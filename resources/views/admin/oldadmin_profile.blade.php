<x-admin_layout>

    
<style>

.container{
    display: flex;
flex-direction: column;
align-items: center;
}

    .title{
        color: #265894;
        font-weight: 600;
        margin-bottom: 40px;

    }

    .sub-title{
        color: #3169ad;
        margin-bottom: 30px;
        font-weight: 600;
        text-align:start;


    }
    .email-container{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: end;
        gap:15px;
    
        
    }
    .input{

        
        border: 1px solid #cccfe1a6;
        border-radius: 4px;
        padding: 5px;
        padding-left:10px;
        color: rgb(79, 78, 78);
        width: 100%;

        box-shadow: 1px 1px 5px 1px rgba(123, 123, 123, 0.048);




    }


    .input:focus {
        outline: 1px solid #cccfe100;
}

    button{
        background-color: #3169ad;
        border: 1px solid #265894;
        box-shadow: 1px 1px 5px 1px rgba(123, 123, 123, 0.048);
        border-radius: 4px;
        padding: 5px 10px 5px 10px;
        color: rgb(236, 236, 236);
        text-wrap: nowrap;

    }


    .full-name{

        width: 100%;
        display: flex;
        align-items: end;
        gap:15px;
    }

    .full-name div{
        width: 100%;
    }

    
    .divider {
        
        margin: 20px 0;
        margin-top: 50px;
        width: 100%;
        height: 1px;
        background-color: #ccc;
      }

    

  .savebtn{
    background-color: rgb(50, 157, 50);
    border: 1px solid rgb(50, 157, 50);
    display: none;

  }

  .item{
    margin-top: 20px;
  }
     
  button:disabled{
    background-color: white;
    border: 1px solid #cccfe1a6;
    color: #cccfe1a6;
    
    
}
  
    </style>

<div class="container px-lg-5 ">
    
    <h2 class="title">Compte</h2>
    <div style="width: 100%">
        <h4 class="sub-title ">Infos Personnels</h4>
    </div>
    
    <div style="width:80%">
    
    <div class="email-container">
            
            <div style="width:80%;">
            
                <form id="update-email-form" action="{{url('/update-email')}}" method="post">
                @csrf
                    <label for="">Adresse Email:</label>
                    <input name="email" id="user-email" class="input" type="email" value="{{Auth::user()->email}}" readonly>
                </form>
            </div>
            <button class="savebtn" id="saveemail" onclick="submitnewemail()">Enregistrer</button>
            <button id="updateemail" onclick="updateemail()">Mise à jour</button>

            
        </div>

        
        
        <div class="email-container mt-4">
            
            <div style="width:80%;">
                
                <form id="update-name-form" action="{{url('/update-name')}}" method="post">
               @csrf
                    <div class="full-name">

                        
                        <div>
                            <label for="">Nom:</label>
                            <input name="lastname" id="user-lastname" class="input" type="text" value="{{Auth::user()->lastname}}" readonly>
                        </div>
                        
                        <div>
                            <label for="">Prenom:</label>
                            <input name="firstname"   id="user-firstname" class="input" type="text" value="{{Auth::user()->firstname}}" readonly>
                        </div>
                    </div>
                </form>
                
                
            </div>
            
            <button class="savebtn" id="savename" onclick="submitnewname()">Enregistrer</button>
            <button id="updatename" onclick="updatename()" >Mise à jour</button>

            
            
        </div>


</div>


<div class="divider"></div>
<div style="width: 100%">
<h4 class="sub-title">Securite</h4>
</div>
        <div class="email-container mt-4">
            
            <div style="width:80%;">
                
                <form id="update-password-form" action="{{url('/update-password')}}" method="post">

                        @csrf
                        <div class="item">
                            <label for="">Mot de passe actuel:</label>
                            <input  id="old_password" class="input" type="password" name="old_password">
                        </div>
                        
                        <div class="item">
                            <label for="">Nouveau mot de passe:</label>
                            <input id="new_password" class="input" type="password" name="password">
                        </div>

                        <div class="item">
                            <label for="">Confirmation du mot de passe:</label>
                            <input id="password_confirmation" class="input" type="password" name="password_confirmation">
                        </div>
                        
                        <div class="item">
                            <button id="updatepassword" onclick="updatepassword()"  disabled>Mise à jour</button>
                        </div>

                </form>
                
                
            </div>
            

            
            
        </div>
        

        
        <div class="divider" style="height: 0.5px;" ></div>
      
        <div style="width: 100%">
        <h4 class="sub-title">Détails</h4>
        </div>

        <div class="email-container mt-4">
            
            <div style="width:80%;">
                
                <div class="full-name">
                    
                    <div>
                    
                        <p ><strong>Role: </strong>{{Auth::user()->role_column}}</p>
                        <p ><strong>Date de creation de compte: </strong>{{Auth::user()->created_at}}</p>
                        <p ><strong>Date de mise a jour de compte: </strong>{{Auth::user()->updated_at}}</p>


                    </div>
                    
                  
                </div>
                
                
            </div>
            
            
        </div>

        <div class="divider"></div>

        
        
        
    </div>







  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>

    function updateemail() {

        const input = document.getElementById('user-email');
        input.removeAttribute('readonly');
        input.style.borderColor="#265894";
        input.focus();

        const updatebtn=document.getElementById('updateemail');
        updatebtn.style.display="none";

        const savebtn=document.getElementById('saveemail');
        savebtn.style.display="block";
        
    }

    function submitnewemail(){

        if(document.getElementById('user-email').value!=""&& document.getElementById('user-email').value!="{{Auth::user()->email}}"){

            document.getElementById('update-email-form').submit();

        }
        else {
            document.getElementById('updateemail').style.display="block";

            document.getElementById('saveemail').style.display="none";


        }
      

    }

    function updatename() {

const input1 = document.getElementById('user-firstname');
const input2 = document.getElementById('user-lastname');

input1.removeAttribute('readonly');
input1.style.borderColor="#265894";
input1.focus();

input2.removeAttribute('readonly');
input2.style.borderColor="#265894";

const updatebtn=document.getElementById('updatename');
updatebtn.style.display="none";

const savebtn=document.getElementById('savename');
savebtn.style.display="block";

}

function submitnewname(){

    if(document.getElementById('user-firstname').value!=""&& document.getElementById('user-firstname').value!="{{Auth::user()->firstname}}" &&document.getElementById('user-firstname').value!=""&& document.getElementById('user-lastname').value!="{{Auth::user()->lastname}}"){

document.getElementById('update-name-form').submit();

}
else {
document.getElementById('updatename').style.display="block";

document.getElementById('savename').style.display="none";


}
}

const input = document.getElementById('old_password');
const button = document.getElementById('updatepassword');

input.addEventListener('keyup', function () {
    if (input.value.trim() !== '') {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
});

  </script>


</x-admin_layout>



