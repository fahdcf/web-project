<x-admin_layout>   
    <div class="container">
       <h1>The list of pending users</h1>
   
       <!-- Make table scrollable on small screens -->
       <div class="table-responsive mt-4">
           <table class="table table-bordered table-striped table-hover">
               <thead style="background-color:rgb(64, 64, 139)">
                   <tr class="text-light text-center ">
                       <th>First Name</th>
                       <th>Last Name</th>
                       <th>Email</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($admins as $admin)
                       <tr>
                           <td>{{ $admin['firstname'] }}</td>
                           <td>{{ $admin['lastname'] }}</td>
                           <td>{{ $admin['email'] }}</td>
                           <td class="d-flex justify-content-center gap-2">
                              
                               <input type="number" hidden id="admin_id_{{ $admin['id'] }}" value="{{ $admin['id'] }}">
                               <button class="btn btn-success btn-sm" onclick="showPopup({{ $admin['id'] }})">Modify</button>
                         
                               <form action="{{ url('/admins/' . $admin['id']) }}" method="POST">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class="btn ml-1 btn-danger btn-sm">Remove</button>
                               </form>
                           </td>
                       </tr>
                   @endforeach
               </tbody>
           </table>
       </div>
   </div>
   


 
  <style>
       /* Overlay background darkening */
       .overlay {
           position: fixed;
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background-color: rgba(0, 0, 0, 0.5);
           display: none;
           justify-content: center;
           align-items: center;
           z-index: 1000;
       }

       /* Popup style */
       .popup {
           background-color: white;
           padding: 20px;
           border-radius: 8px;
           text-align: center;
           width: 300px;
       }

       .popup select {
           width: 100%;
           padding: 8px;
           margin-bottom: 10px;
       }

       .popup button {
           padding: 10px 20px;
           background-color: green;
           color: white;
           border: none;
           border-radius: 5px;
           cursor: pointer;
       }

       .popup button:hover {
           background-color: darkgreen;
       }
   </style>

  <!-- Overlay -->
  <div id="overlay" class="overlay">
   <div class="popup">
       <h3>Choose Role</h3>
       <!-- Form for submitting the role selection -->
       <form id="popupForm" action="" method="POST">
           @csrf
           @method('PATCH')

           <!-- Dropdown for selecting role -->
           <select name="role" id="roleSelect">
               <option value="admin">Admin</option>
               <option value="professor">Professor</option>
               <option value="student">Student</option>
               <option value="vocataire">Vocataire</option>
           </select>
           <br>
           
           <!-- Approve button to submit form -->
           <button type="submit" class="btn btn-success btn-sm">Approve</button>
       </form>
   </div>
</div>



<script>
   // Function to show the popup and set the hidden input's value for the user id
   function showPopup(userId) {
       // Get the hidden input with the corresponding user id
       var userIdInput = document.getElementById('admin_id_' + userId);
       var userIdValue = userIdInput.value;
       // Set the action of the form to include the correct URL for the user
       var form = document.getElementById('popupForm');
       form.action = "{{ url('/admins') }}/" + userId;
       
       // Show the overlay and popup
       document.getElementById("overlay").style.display = "flex";
   }
</script>

</x-admin_layout>