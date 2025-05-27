<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenggunaFactory extends Factory
{
    protected $model = Pengguna::class;

    public function definition()
    {
        return [
            'nik' => $this->faker->unique()->numerify('##########'), // Generate NIK unik
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Set password default
            'nama_lengkap' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_lengkap' => $this->faker->address,
            'nomor_telepon' => $this->faker->phoneNumber,
            'nama_ibu_kandung' => $this->faker->name,
        ];
    }
}