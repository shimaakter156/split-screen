<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YamahaFeedback extends Model
{
    use HasFactory;
    protected $table='YamahaFeedback';
    protected $primaryKey='Id';
    protected $guarded=[];
    public $timestamps = false;
}
