<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    /**
     * Disabilito i timestamp di default (created_at, deleted_at, updated_at)
     */
    public $timestamps = false; 

    /**
     * Il nome della tabella
     */
    protected $table = 'form';

    /**
     * Gli attributi assegnabili
     *
     * @var array
     */
    protected $fillable = [
        'title', 'student_name', 'student_surname', 'student_email', 'student_password', 'teacher_name', 'teacher_surname', 'teacher_email', 'teacher_phone', 'expert1_name', 'expert1_surname', 'expert1_email', 'expert1_phone', 'expert2_name', 'expert2_surname', 'expert2_email', 'expert2_phone', 'id_user'
    ];
}
