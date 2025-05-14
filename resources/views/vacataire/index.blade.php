<x-coordonnateur_layout>
  <div class="container py-4">
  <h2>Assigned Teaching Units</h2>

  @if($assignments->isNotEmpty())
  <table class="table table-striped">
  <thead>
  <tr>
  <th>UE Title</th>
  <th>UE Code</th>
  <th>Semester</th>
  <th>CM Hours</th>
  <th>TD Hours</th>
  <th>TP Hours</th>
  <th>Actions</th>
  </tr>
  </thead>
  <tbody>
  @foreach($assignments as $assignment)
  <tr>
  <td>{{ $assignment->module->name }}</td>
  <td>{{ $assignment->module->code }}</td>
  <td>{{ $assignment->module->semester }}</td>
  <td>{{ $assignment->module->cm_hours }}</td>
  <td>{{ $assignment->module->td_hours }}</td>
  <td>{{ $assignment->module->tp_hours }}</td>
  <td>
  <a href="{{ route('vacataire.grades.upload', $assignment->module->id) }}" class="btn btn-sm btn-primary">Upload Grades</a>
  </td>
  </tr>
  @endforeach
  </tbody>
  </table>
  @else
  <p>No teaching units assigned to you.</p>
  @endif
  </div>
 </x-coordonnateur_layout>