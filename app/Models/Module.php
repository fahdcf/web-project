<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules'; // Vérifiez cette ligne
    use HasFactory;

    // Liste des statuts possibles

    protected $fillable = [
        'code',
        'name',
        'credits',
        'evaluation',
        'specialite',
        'semester',
        'description',

        'cm_hours',
        'td_hours',
        'tp_hours',
        'autre_hours',


        'filiere_id',
        'professor_id',
        'responsable_id',

        'nb_groupes_td',
        'nb_groupes_tp',

    ];


    // public function getStatusAttribute($value)
    // {
    //     return match ($value) {
    //         1 => 'Actif',
    //         0 => 'Inactif',
    //         null => 'Non assigné',
    //         default => $value // Pour les cas où c'est déjà en texte
    //     };
    // }

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
        return $this->belongsToMany(User::class, 'module_user');
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

    // // app/Models/Module.php
    // public function assignments()
    // {P
    //     return $this->hasMany(Assignment::class);
    // }
    // // Vérifie si le module est validé
    // public function isValidated()
    // {
    //     return $this->status === self::STATUS_VALIDATED;
    // }
}
