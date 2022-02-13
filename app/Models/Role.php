<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $table= "role_type";
    protected $primaryKey = "id";
    protected $guarded =[];
    public $timestamps = false;
    protected $fillable = [
        'id','name','name_screen',
    ];

}
