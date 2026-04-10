<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanPmb extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_pmb';
    protected $fillable = ['is_tutup', 'pesan_tutup'];
}
