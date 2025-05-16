<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Groupe extends Model
{

    use HasFactory;

    protected $guarded=[];
    /**
     * Get the module that the group belongs to.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }



    public function students(){
        return 9;
    }
    /////////////////////////////////////////////////
    public function getFullNameAttribute(): string
    {
        return "{$this->module->code}-{$this->type}-{$this->id}";
    }
}