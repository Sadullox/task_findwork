<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'desc',
        'position_id',
        'parent_id',
        'right',
        'test_type'
    ];
    
    /*
    * test type
    */
    const UNIQUETYPE = 'unique';
    const CLOSEDTYPE = 'closed';
    const MULTIPLETYPE = 'multiple';
}
