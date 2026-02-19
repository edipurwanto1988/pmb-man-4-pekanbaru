<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageModule extends Model
{
    use HasFactory;

    protected $fillable = ['nama_modul', 'kode_modul', 'view_path'];

    public function sections()
    {
        return $this->hasMany(LandingPageSection::class);
    }
}
