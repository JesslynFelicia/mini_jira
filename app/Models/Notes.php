<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    //

    protected $table = 'tb_notes';
    protected $primaryKey = 'id_notes';
    protected $fillable = [
        'notes_title',
        'notes',
        'id_user'
    ];
}
