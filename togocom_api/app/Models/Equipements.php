<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipements extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'equipements';
    public function site()
    {
        return $this->belongsTo(Sites::class, 'sites_id');
    }
   
}
