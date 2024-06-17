<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'sites';
     public function equipement()
    {
        return $this->hasMany(Equipements::class, 'sites_id');
    }
}
