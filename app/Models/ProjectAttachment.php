<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_update_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function projectUpdate()
    {
        return $this->belongsTo(ProjectUpdate::class);
    }
}