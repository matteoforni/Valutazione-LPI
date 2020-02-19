<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * Disabilito i timestamp di default (created_at, deleted_at, updated_at)
     */
    public $timestamps = false; 

    /**
     * Il nome della tabella
     */
    protected $table = 'role';

    /**
     * Gli attributi assegnabili
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
