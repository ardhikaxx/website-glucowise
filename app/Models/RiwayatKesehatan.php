<?php

// RiwayatKesehatan Model

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    use HasFactory;

    // Specify the table if it's different from the default plural form
    protected $table = 'riwayat_kesehatan';

    // Set the primary key column
    protected $primaryKey = 'id_riwayat';  // Use the correct primary key here

    // Disable auto-increment if it's not an auto-increment field
    public $incrementing = true;

    // Specify the data types for the primary key
    protected $keyType = 'int';  // or 'bigint' if it's a bigint

    // Define the fillable fields
    protected $fillable = [
        'id_data',
        'id_admin',
        'kategori_risiko',
        'catatan',
    ];

    // Define relationships
    public function dataKesehatan()
    {
        return $this->belongsTo(DataKesehatan::class, 'id_data', 'id_data');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
