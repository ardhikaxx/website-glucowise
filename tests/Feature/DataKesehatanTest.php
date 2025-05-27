<?php
namespace Tests\Feature;

use App\Models\Admin;
use App\Models\DataKesehatan;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DataKesehatanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test menampilkan data kesehatan dengan pagination.
     *
     * @return void
     */
    public function test_index_shows_data_kesehatan()
    {
        $admin = Admin::factory()->create([
            'nama_lengkap' => 'Rex Bruen',
            'email' => 'bidan2@example.com',
            'jenis_kelamin' => 'laki-laki',
            'password' => Hash::make('password'),
            'hak_akses' => 'Bidan', // Asumsikan ini hak akses admin
        ]);

        // Buat beberapa data kesehatan untuk pengujian
        $pengguna = Pengguna::factory()->create([
            'nik' => '1234567890',
            'password'=> Hash::make('password'),
            'tempat_lahir'=> 'Jember',
            'nama_lengkap' => 'John Doe',
            'tanggal_lahir'=> '2025-05-15',
            'jenis_kelamin'=> 'Laki-laki',
            'alamat_lengkap'=> 'John Doe',
            'nomor_telepon'=> '3456745678',
            'nama_ibu_kandung'=> 'John Doe'
        ]);

        DataKesehatan::create([
            'nik' => $pengguna->nik,
            'tanggal_pemeriksaan' => now(),
            'riwayat_keluarga_diabetes' => 'Tidak',
            'umur' => 30,
            'tinggi_badan' => 170,
            'berat_badan' => 65,
            'gula_darah' => 100,
            'lingkar_pinggang' => 80,
            'tensi_darah' => '120',
        ]);

        $response = $this->actingAs($admin)->get('/data-kesehatan');

        $response->assertStatus(200);
        $response->assertViewIs('layouts.Data-kesehatan.data_kesehatan');
        $response->assertSee('John Doe');  // Memastikan data pengguna ditampilkan
    }
        /**
     * Test pencarian data kesehatan berdasarkan nama pengguna.
     *
     * @return void
     */
    public function test_search_by_name()
    {
        $admin = Admin::factory()->create([
                      'nama_lengkap' => 'Rex Bruen',
            'email' => 'bidan2@example.com',
            'jenis_kelamin' => 'laki-laki',
            'password' => Hash::make('password'),
            'hak_akses' => 'Bidan', // Asumsikan ini hak akses admin
        ]);

        // Buat pengguna dan data kesehatan
        $pengguna = Pengguna::factory()->create([
            'nik' => '1234567890',
            'password'=> Hash::make('password'),
            'tempat_lahir'=> 'Jember',
            'nama_lengkap' => 'John Doe',
            'tanggal_lahir'=> '2025-05-15',
            'jenis_kelamin'=> 'Laki-laki',
            'alamat_lengkap'=> 'John Doe',
            'nomor_telepon'=> '3456745678',
            'nama_ibu_kandung'=> 'John Doe'
        ]);

        DataKesehatan::create([
            'nik' => $pengguna->nik,
            'tanggal_pemeriksaan' => now(),
            'riwayat_keluarga_diabetes' => 'Tidak',
            'umur' => 30,
            'tinggi_badan' => 170,
            'berat_badan' => 65,
            'gula_darah' => 100,
            'lingkar_pinggang' => 80,
            'tensi_darah' => '120',
        ]);

        $response = $this->actingAs($admin)->get('/data-kesehatan/search?search=John');

        $response->assertStatus(200);
        $response->assertSee('John Doe'); // Memastikan data ditemukan berdasarkan nama
    }

    /**
     * Test pencarian data kesehatan berdasarkan NIK.
     *
     * @return void
     */
  
    /**
     * Test menampilkan detail data kesehatan.
     *
     * @return void
     */
    public function test_show_data_kesehatan_detail()
    {
        $admin = Admin::factory()->create([
            'nama_lengkap' => 'Rex Bruen',
            'email' => 'bidan2@example.com',
            'jenis_kelamin' => 'laki-laki',
            'password' => Hash::make('password'),
            'hak_akses' => 'Bidan', // Asumsikan ini hak akses admin
        ]);

        $pengguna = Pengguna::factory()->create([
            'nik' => '1234567890',
            'password'=> Hash::make('password'),
            'tempat_lahir'=> 'Jember',
            'nama_lengkap' => 'John Doe',
            'tanggal_lahir'=> '2025-05-15',
            'jenis_kelamin'=> 'Laki-laki',
            'alamat_lengkap'=> 'John Doe',
            'nomor_telepon'=> '3456745678',
            'nama_ibu_kandung'=> 'John Doe'
        ]);

        $dataKesehatan = DataKesehatan::create([
            'nik' => $pengguna->nik,
            'tanggal_pemeriksaan' => now(),
            'riwayat_keluarga_diabetes' => 'Tidak',
            'umur' => 30,
            'tinggi_badan' => 170,
            'berat_badan' => 65,
            'gula_darah' => 100,
            'lingkar_pinggang' => 80,
            'tensi_darah' => '120',
        ]);

        $response = $this->actingAs($admin)->get("/data-kesehatan/detail/{$pengguna->nik}");

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('100');  // Mengecek apakah data gula darah muncul
    }
    /**
     * Test untuk mengedit dan memperbarui data kesehatan.
     *
     * @return void
     */
   public function test_edit_and_update_data_kesehatan()
{
    $admin = Admin::factory()->create([
        'nama_lengkap' => 'Rex Bruen',
        'email' => 'bidan2@example.com',
        'jenis_kelamin' => 'laki-laki',
        'password' => Hash::make('password'),
        'hak_akses' => 'Bidan', // Asumsikan ini hak akses admin
    ]);

    $pengguna = Pengguna::factory()->create([
        'nik' => '1234567890',
        'password'=> Hash::make('password'),
        'tempat_lahir'=> 'Jember',
        'nama_lengkap' => 'John Doe',
        'tanggal_lahir'=> '2025-05-15',
        'jenis_kelamin'=> 'Laki-laki',
        'alamat_lengkap'=> 'John Doe',
        'nomor_telepon'=> '3456745678',
        'nama_ibu_kandung'=> 'John Doe'
    ]);

    // Simpan data kesehatan dengan format tanggal yang hanya tanggal (tanpa waktu)
    $dataKesehatan = DataKesehatan::create([
        'nik' => $pengguna->nik,
        'tanggal_pemeriksaan' => now()->toDateString(), // Menggunakan hanya tanggal
        'riwayat_keluarga_diabetes' => 'Tidak',
        'umur' => 30,
        'tinggi_badan' => 170,
        'berat_badan' => 65,
        'gula_darah' => 100,
        'lingkar_pinggang' => 80,
        'tensi_darah' => '120',
    ]);

    // Verifikasi bahwa dataKesehatan berhasil disimpan dengan tanggal tanpa waktu
    $this->assertDatabaseHas('data_kesehatan', [
        'nik' => $pengguna->nik,
        'tanggal_pemeriksaan' => $dataKesehatan->tanggal_pemeriksaan, // Pastikan hanya tanggal yang dibandingkan
    ]);

    // Mengedit data
    $response = $this->actingAs($admin)->get("/data-kesehatan/edit/{$pengguna->nik}/{$dataKesehatan->tanggal_pemeriksaan}");

    // Pastikan status 200 dan data ada di halaman
    $response->assertStatus(200);
    $response->assertSee('Edit Data Kesehatan');  // Pastikan halaman edit tampil

    // Memperbarui data
    $response = $this->actingAs($admin)->put("/data-kesehatan/update/{$pengguna->nik}/{$dataKesehatan->tanggal_pemeriksaan}", [
        'tanggal_pemeriksaan' => now()->toDateString(), // Pastikan format tanggal yang digunakan sesuai
        'umur' => 31,
        'tinggi_badan' => 172,
        'berat_badan' => 67,
        'gula_darah' => 110,
        'lingkar_pinggang' => 85,
        'tensi_darah' => '120',
        'riwayat_keluarga_diabetes' => 'Ya',
    ]);

    // Pastikan redirect ke halaman show
    $response->assertRedirect(route('dataKesehatan.show', ['nik' => $pengguna->nik]));
    $response->assertSessionHas('success');  // Pastikan ada pesan sukses
}


}