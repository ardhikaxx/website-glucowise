<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins'; // Pastikan tabel sesuai dengan database

    protected $fillable = ['nama', 'email', 'jenis_kelamin'];
}
