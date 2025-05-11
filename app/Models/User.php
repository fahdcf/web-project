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
        'firstname', // Add this field
        'lastname', // Add this field
        'email',
        'password',
        'departement'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function role()
    {
        return $this->hasOne(Role::class, foreignKey: 'user_id');
    }

    public function user_details()
    {
        return $this->hasOne(user_detail::class);
    }

    // //////////////////////////////////////////////////////////////////////////

    public function modules()
    {
        // Un module peut être enseigné par plusieurs utilisateurs (professeurs et vacataires), et un utilisateur peut enseigner dans plusieurs modules
        return $this->belongsToMany(Module::class, 'module_user');
    }

    // public function modules()
    // {
    //     return $this->hasMany(Module::class, 'professor_id');
    // }

    // Fonction pour vérifier si l'utilisateur est un coordonnateur

    public function isCoordonnateur(): bool
    {
        return (bool) optional($this->role)->iscoordonnateur;
    }

    public function isProfessor(): bool
    {
        return (bool) optional($this->role)->isprof;
    }

    public function isAdmin(): bool
    {
        return (bool) optional($this->role)->isadmin;
    }

    // And other role methods following the same pattern...

    public function getmanageAttribute()
    {
        if ($this->role->ischef) {
            return Departement::where('user_id', $this->id)->first();
        } elseif ($this->role->iscoordonnateur) {
            return Filiere::where('coordonnateur_id', $this->id)->first();
        }
    }

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class);
    }

    // public function managedDepartment() {
    //     return $this->hasOne(Departement::class, 'chef_id'); // If you track department heads
    // }
}
