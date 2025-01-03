<?php

namespace App\Models;
use App\Models\Issue;


use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'tb_project';
    protected $primaryKey = 'id_project';
    protected $fillable = [
        'project_title', 
        'owner',
        'pic',
        'due_date'
    ];
    public function issues()
    {
        return $this;
    }
}
