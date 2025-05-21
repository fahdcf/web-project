<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model


{
    protected $table = 'seances';


    protected $guarded = [];

    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function emploi()
    {
        return $this->belongsTo(Emploi::class);
    }



    //////////////////////////////////////////
    /**
     * Calcule la durée de la séance en minutes
     *
     * @return int
     */
    public function getDurationInMinutesAttribute()
    {
        $debut = \Carbon\Carbon::createFromFormat('H:i', $this->heure_debut);
        $fin = \Carbon\Carbon::createFromFormat('H:i', $this->heure_fin);

        return $fin->diffInMinutes($debut);
    }

    /**
     * Calcule la durée de la séance au format heures:minutes
     *
     * @return string
     */
    public function getDurationFormattedAttribute()
    {
        $minutes = $this->duration_in_minutes;
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%dh%02d', $hours, $remainingMinutes);
    }
}
