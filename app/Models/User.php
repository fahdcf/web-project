<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',   // Add this field
        'lastname',    // Add this field
        'email',
        'password',
        'departement'    // Add 'role' if you're using it as a fillable field
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user_details()
    {
        return $this->hasOne(user_detail::class);
    }
    public function role()
    {
        return $this->hasOne(Role::class, 'user_id');
    }

    public function getmanageAttribute()
    {
        if ($this->role->ischef) {

            return Departement::where('user_id', $this->id)->first();
        } else if ($this->role->iscoordonnateur) {
            return Filiere::where('coordonnateur_id', $this->id)->first();
        } else return null;
    }


    public function gethoursAttribute()
    {

        $modules = Module::where('professor_id', $this->id)->get();

        $hours = 0;

        if ($modules) {

            foreach ($modules as $key => $module) {

                $hours = $hours + $module->cm_hours + $module->tp_hours + $module->td_hours;
            }
        }

        return $hours;
    }


    // //////////////////////////////////////////////////////////////////////////

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function modules()
    {
        // Un module peut être enseigné par plusieurs utilisateurs (professeurs et vacataires), et un utilisateur peut enseigner dans plusieurs modules
        return $this->hasMany(Module::class, 'professor_id');
    }


    // public function getCoordonatedFiliere()
    // {
    //     if($this->role->iscoordonnateur) {
    //         return Filiere::where('coordonnateur_id', $this->id)->first();
    //     } else abort(403,"you are not a coordinator for this action . log in first..");
    // }



    public function modulesVacataire()
    {
        return $this->belongsToMany(Module::class, 'module_user')->withPivot('role', 'hours');
    }

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class);
    }

    public function isCoordonnateur(): bool
    {
        return (bool) optional($this->role)->iscoordonnateur;
    }

    public function isProfessor(): bool
    {
        return (bool) optional($this->role)->isprof;
    }
    public function isvacataire(): bool //used
    {
        return (bool) optional($this->role)->isvocataire;
    }

    public function isAdmin(): bool
    {
        return (bool) optional($this->role)->isadmin;
    }
    //////////////////////////////////////////////////////

    public function assignedModules()
    {
        return $this->belongsToMany(Module::class, 'assignments', 'prof_id', 'module_id');
    }



    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'prof_id');
    }
}
