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

    protected $guarded = [];

     public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    

    // Relation avec le professeur responsable
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id'); // A module belongs to a professor
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'module_user');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id'); // A module belongs to a professor
    }

   


    // Relation avec la filière
    public function filiere()
    {

        return $this->belongsTo(Filiere::class); // A module belongs to a filiere
    }

    public function getProfCoursAttribute(){
        

        $assaigns=Assignment::where('module_id',$this->id)->where('teach_cm',1)->first();

       

        if($assaigns){

           $prof=User::findOrFail($assaigns->prof_id);
           return $prof;

        }
                else return null;

    }

     public function getProfTpAttribute(){
        

        $assaigns=Assignment::where('module_id',$this->id)->where('teach_tp',1)->first();

       

        if($assaigns){

           $prof=User::findOrFail($assaigns->prof_id);
           return $prof;

        }

                else return null;

    }


     public function getProfTdAttribute(){
        

        $assaigns=Assignment::where('module_id',$this->id)->where('teach_td',1)->first();

       

        if($assaigns){

           $prof=User::findOrFail($assaigns->prof_id);
           return $prof;

        }

        else return null;
    }

    
    // Calcul du volume horaire total
    public function volume_horaire()
    {
        
        return $this->cm_hours + $this->td_hours + $this->tp_hours;
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    /////////////////////////////////////////////////
    // public function groupes()
    // {
    //     return $this->hasMany(Groupe::class,); // A module has many groupes 
    // }

    // public function tdGroups(): HasMany
    // {
    //     return $this->groupes()->where('type', 'TD');
    // }

    // public function tpGroups(): HasMany
    // {
    //     return $this->groupes()->where('type', 'TP');
    // }

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

    /////////////////////////////////////////////////////////////////////////////////
    // Dans Module.php
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }


    public function tpAssignation()
    {
        return $this->hasOne(Assignment::class)->where("teach_tp",true);
    }

    public function tdAssignation()
    {
        return $this->hasOne(Assignment::class)->where("teach_td",true);
    }

    public function cmAssignation()
    {
        return $this->hasOne(Assignment::class)->where("teach_cm",true);
    }

    
}
////////////////////
