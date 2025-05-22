<?php
namespace App\Models;


use App\Models\Filiere;
use App\Models\Seance;
use App\Models\ScheduleItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emploi extends Model
{
    protected $table = 'emplois';

    protected $guarded = [];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }
    //////////////////////////////////
    public function items()
    {
        return $this->hasMany(ScheduleItem::class);
    }
}
