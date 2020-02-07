<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{

    /**
     * Disabilito i timestamp di default (created_at, deleted_at, updated_at)
     */
    public $timestamps = false; 

    /**
     * Il nome della tabella
     */
    protected $table = 'justification';

    /**
     * Gli attributi assegnabili
     *
     * @var array
     */
    protected $fillable = [
        'text', 'id_point'
    ];
}
