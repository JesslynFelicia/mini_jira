<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //
    protected $table = 'tb_issue';
    protected $primaryKey = 'id_issue';
    public function project(){
        
        return $this;
    }
    protected $fillable = [
        'id_project',
        'issue_title',
        'issue_type',
        'issue_desc',
        'note',
        'priority',
        'pic',
        'due_date',
        'status',
        'filter'
    ];
}
