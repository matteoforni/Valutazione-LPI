<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Has extends Model
{

    /**
     * Disabilito i timestamp di default (created_at, deleted_at, updated_at)
     */
    public $timestamps = false; 

    /**
     * Il nome della tabella
     */
    protected $table = 'has';

    /**
     * Gli attributi assegnabili
     *
     * @var array
     */
    protected $fillable = [
        'id_form', 'id_point'
    ];
}
