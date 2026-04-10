<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPmb extends Model
{
    use HasFactory;

    protected $table = 'tahun_pmb';
    protected $fillable = ['nama', 'is_active'];
}
