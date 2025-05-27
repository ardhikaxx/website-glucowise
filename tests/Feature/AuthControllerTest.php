<?php
namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test untuk menampilkan form login.
     *
     * @return void
     */
    public function test_show_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test login dengan kredensial yang benar.
     *
     * @return void
     */public function test_login_success_with_valid_credentials_and_hak_akses_bidan()
    {
        // Membuat admin dengan hak akses 'Bidan'
        $admin = Admin::create([
            'nama_lengkap' => 'Admin Bidan',
            'email' => 'adminbidan@example.com',
            'password' => Hash::make('password123'),
            'hak_akses' => 'Bidan',
        ]);

        // Mengirimkan permintaan login
        $response = $this->post('/login', [
            'email' => 'adminbidan@example.com',
            'password' => 'password123',
        ]);

        // Memastikan pengguna diarahkan ke dashboard
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($admin);  // Memastikan admin yang login adalah admin dengan hak akses 'Bidan'
    }

    /**
     * Test login dengan kredensial yang salah.
     *
     * @return void
     */
    public function test_login_failure_with_invalid_credentials()
    {
        // Mengirimkan permintaan login dengan kredensial yang salah
        $response = $this->post('/login', [
            'email' => 'adminbidan@example.com',
            'password' => 'wrongpassword',
        ]);

        // Memastikan terdapat error pada session
        $response->assertSessionHasErrors('email');
    }
    /**
     * Test login dengan kredensial yang salah.
     *
     * @return void
     */
    public function test_login_failure()
    {
        // Test login dengan email yang salah
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        // Memastikan terdapat error pada session
        $response->assertSessionHasErrors('email');
    }
}