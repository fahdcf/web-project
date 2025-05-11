<?php
// app/Models/Assignment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['module_id', 'user_id', 'role', 'status', 'rejection_reason'];

    // Relation avec le module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Relation avec l'utilisateur (prof/vacataire)
    public function professor()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // Helpers pour le statut
    public function isValidated()
    {
        return $this->status === 'validated';
    }
}
