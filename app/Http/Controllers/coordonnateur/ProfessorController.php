<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\prof_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        return view('professor.index');
    }

    public function myRequests()
    {

        $FilieretargetIDs =  [1,2,3];

        // $module_requests = prof_request::whereIn('module_id', $FilieretargetIDs)->get();
        $module_requests = prof_request::where('prof_id',auth()->user()->id)->get();

        return view('professor.mes_requests', [
            'module_requests' => $module_requests,

        ]);
    }




    // public function mesModules()
    // {


    //     $user = auth()->user();
    //     $modules = $user->assignedModules()->with('filiere')
    //         ->get();


    //     return view('modules.mesModules', [
    //         'modules' => $modules
    //     ]);
    // }

    public function mesModules()
    {
        $professor = auth()->user();

        $modules = $professor->assignedModules()
            ->with('filiere') // Chargement anticipé de la filière
            ->orderBy('semester')
            ->get();

        // $modules = Module::where('professor_id',$professor->id)
        //     ->with('filiere') // Chargement anticipé de la filière
        //     ->orderBy('semester')
        //     ->get();

        return view('modules.mesModules', [
            'currentSemester' => $this->getCurrentSemester(),
            'modules' => $modules
        ]);
    }


    //helper
    private function getCurrentSemester()
    {
        return (date('n') >= 9 || date('n') <= 2) ? 1 : 2; // S1: Sept-Fév, S2: Mars-Août
    }
}




        // <div class="upload-card mt-4">
        //     <div class="card-header bg-light">
        //         <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des Uploads</h5>
        //     </div>
        //     <div class="card-body">
        //         <div class="mb-3">
        //             <input type="text" id="historySearch" class="form-control" placeholder="Rechercher par module, session ou date...">
        //         </div>
                
        //         @if ($uploads->count() > 0)
        //             <div class="table-responsive">
        //                 <table class="table table-hover" id="uploadsTable">
        //                     <thead class="table-light">
        //                         <tr>
        //                             <th>Date</th>
        //                             <th>Module</th>
        //                             <th>Session</th>
        //                             <th>Fichier</th>
        //                             <th>Enregistrements</th>
        //                             <th>Statut</th>
        //                             <th>Actions</th>
        //                         </tr>
        //                     </thead>
        //                     <tbody>
        //                         @foreach ($uploads as $upload)
        //                             <tr>
        //                                 <td>{{ $upload->created_at->format('d/m/Y H:i') }}</td>
        //                                 <td>{{ $upload->module->name }}</td>
        //                                 <td>
        //                                     <span class="badge bg-{{ $upload->session_type === 'normale' ? 'primary' : 'warning' }}">
        //                                         {{ ucfirst($upload->session_type) }}
        //                                     </span>
        //                                 </td>
        //                                 <td>
        //                                     <a href="{{ Storage::url($upload->storage_path) }}" target="_blank">
        //                                         <i class="fas fa-file-excel text-success me-2"></i>
        //                                         {{ $upload->original_name ?? 'Fichier' }}
        //                                     </a>
        //                                 </td>
        //                                 <td>{{ $upload->record_count ?? 'N/A' }}</td>
        //                                 <td>
        //                                     @if ($upload->status == 'active')
        //                                         <span class="badge bg-success">Actif</span>
        //                                     @else
        //                                         <span class="badge bg-danger">Annulé</span>
        //                                     @endif
        //                                 </td>
        //                                 <td>
        //                                     @if ($upload->status == 'active')
        //                                         <button class="btn btn-sm btn-danger" onclick="confirmCancel('{{ $upload->id }}')">
        //                                             <i class="fas fa-times"></i> Annuler
        //                                         </button>
        //                                     @endif
        //                                 </td>
        //                             </tr>
        //                         @endforeach
        //                     </tbody>
        //                 </table>
        //             </div>
                    
        //             <nav aria-label="Page navigation">
        //                 <ul class="pagination justify-content-center">
        //                     {{ $uploads->links() }}
        //                 </ul>
        //             </nav>
        //         @else
        //             <div class="alert alert-info mb-0">
        //                 <i class="fas fa-info-circle me-2"></i>
        //                 Aucun upload enregistré pour le moment.
        //             </div>
        //         @endif
        //     </div>
        // </div>



        // historySearch.addEventListener('input', function() {
        //         const searchText = this.value.toLowerCase();
        //         const rows = document.querySelectorAll('#uploadsTable tbody tr');
                
        //         rows.forEach(row => {
        //             const rowText = row.textContent.toLowerCase();
        //             row.style.display = rowText.includes(searchText) ? '' : 'none';
        //         });
        //     });