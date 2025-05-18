<?php

namespace App\Models;

use App\Models\Groupe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $table = 'modules'; // Vérifiez cette ligne
    use HasFactory;

    // Liste des statuts possibles

    // protected $fillable = [
    //     'code',
    //     'name',
    //     'credits',
    //     'evaluation',
    //     'specialite',
    //     'semester',
    //     'description',

    //     'cm_hours',
    //     'td_hours',
    //     'tp_hours',
    //     'autre_hours',

    //     'status',
    //     'type',
    //     'parent_id',

    //     'filiere_id',
    //     'professor_id',
    //     'responsable_id',

    //     // 'nb_groupes_td',
    //     // 'nb_groupes_tp',

    // ];

    protected $guarded = [];


    // Relation avec le professeur responsable
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id'); // A module belongs to a professor
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id'); // A module belongs to a professor
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'module_user')->withPivot('role', 'hours');
    }

    // Relation avec la filière
    public function filiere()
    {
        return $this->belongsTo(Filiere::class); // A module belongs to a filiere
    }

    // Calcul du volume horaire total
    public function volume_horaire()
    {
        return $this->cm_hours + $this->td_hours + $this->tp_hours;
    }


    /////////////////////////////////////////////////
    public function groupes()
    {
        return $this->hasMany(Groupe::class,); // A module has many groupes 
    }

    public function tdGroups(): HasMany
    {
        return $this->groupes()->where('type', 'TD');
    }

    public function tpGroups(): HasMany
    {
        return $this->groupes()->where('type', 'TP');
    }

    ///////////////////////////////
    public function requests()
    {
        return $this->hasMany(prof_request::class, 'target_id')->where('type', 'module');;
    }
    ////////


    public function notes()
    {
        return $this->hasMany(Note::class);
    }



    public function students()
    {
        return $this->belongsToMany(Student::class, 'notes')
            ->withPivot('note', 'session_type', 'semester');
    }
}
////////////////////
