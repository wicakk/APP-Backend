<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\dashboard\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\API\CutiController;
use App\Http\Controllers\API\PerubahanPegawaiController;
use App\Http\Controllers\API\LemburController;
use App\Http\Controllers\API\PengajuanAbsensiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\API\AuthController;



Route::get('/', function () {
        return view('pages.leading.index', ['title' => 'PT Digital Teknologi Quantum']);
    })->name('company');

// landing page
Route::get('/', [HomeController::class, 'landing_thumbnails']);
Route::get('/team', [HomeController::class, 'landing_teams']);
Route::get('/contact-us', [HomeController::class, 'landing_contact']);
Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');



Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $ip = request()->ip();

        // Log visitor jika IP belum tercatat hari ini
        $today = now()->toDateString();
        $exists = \App\Models\Visitor::where('ip_address', $ip)
            ->whereDate('created_at', $today)
            ->exists();

        if (!$exists) {
            $geo = [];
            try {
                $safeIp = filter_var($ip, FILTER_VALIDATE_IP);
                if ($safeIp) {
                    $context = stream_context_create(['http' => ['timeout' => 3]]);
                    $response = file_get_contents("https://ipapi.co/{$safeIp}/json/", false, $context);
                    if ($response) {
                        $data = json_decode($response, true);
                        $geo = [
                            'country' => $data['country_name'] ?? null,
                            'countryCode' => $data['country_code'] ?? null,
                            'city' => $data['city'] ?? null,
                        ];
                    }
                }
            } catch (\Exception $e) {
                // ignore
            }

            \App\Models\Visitor::create([
                'ip_address' => $ip,
                'country' => $geo['country'] ?? 'Unknown',
                'country_code' => $geo['countryCode'] ?? null,
                'city' => $geo['city'] ?? null,
            ]);
        }

        $services = \App\Models\Service::all();

        // Statistik visitor per negara
        $visitorStats = \App\Models\Visitor::selectRaw('country, country_code, COUNT(*) as total')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->get();

        // List visitor terbaru dengan pagination
        $recentVisitors = \App\Models\Visitor::latest()->paginate(10);

        return view('pages.dashboard.ecommerce', [
            'title' => 'PT Digital Teknologi Quantum Dashboard',
            'services' => $services,
            'visitorStats' => $visitorStats,
            'recentVisitors' => $recentVisitors,
        ]);
    })->name('dashboard');

    Route::get('/contact', function () {
        return view('pages.dashboard.contact.index', ['title' => 'PT Digital Teknologi Quantum Contact']);
    })->name('contact');

    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');

    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'Blank']);
    })->name('blank');

    Route::get('/error-404', function () {
        return view('pages.errors.error-404', ['title' => 'Error 404']);
    })->name('error-404');

    Route::get('/home', function () {
        return view('pages.home.index', ['title' => 'home']);
    })->name('home');

    // Home / thumbnails
    Route::get('home', [HomeController::class, 'index'])->name('home.index');
    Route::get('home/create', [HomeController::class, 'create'])->name('home.create');
    Route::post('home', [HomeController::class, 'store'])->name('home.store');
    Route::get('home/{home}/edit', [HomeController::class, 'edit'])->name('home.edit');
    Route::put('home/{home}', [HomeController::class, 'update'])->name('home.update');
    Route::delete('home/{home}', [HomeController::class, 'destroy'])->name('home.destroy');

    // Client
    Route::get('client', [ClientController::class, 'index'])->name('client.index');
    Route::get('client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('client', [ClientController::class, 'store'])->name('client.store');
    Route::get('client/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('client/{client}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('client/{client}', [ClientController::class, 'destroy'])->name('client.destroy');

    // Service
    Route::get('service', [ServiceController::class, 'index'])->name('service.index');
    Route::get('service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('service', [ServiceController::class, 'store'])->name('service.store');
    Route::get('service/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('service/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('service/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

    // Visi
    Route::get('visi', [VisiMisiController::class, 'visi'])->name('visi.index');
    Route::get('visi/create', [VisiMisiController::class, 'create_visi'])->name('visi.create_visi');
    Route::post('visi', [VisiMisiController::class, 'store_visi'])->name('visi.store_visi');
    Route::get('visi/{visi}/edit', [VisiMisiController::class, 'edit_visi'])->name('visi.edit_visi');
    Route::put('visi/{visi}', [VisiMisiController::class, 'update_visi'])->name('visi.update_visi');
    Route::delete('visi/{visi}', [VisiMisiController::class, 'destroy_visi'])->name('visi.destroy_visi');


    // Misi
    Route::get('misi', [VisiMisiController::class, 'misi'])->name('misi.index');
    Route::get('misi/create', [VisiMisiController::class, 'create_misi'])->name('misi.create_misi');
    Route::post('misi', [VisiMisiController::class, 'store_misi'])->name('misi.store_misi');
    Route::get('misi/{misi}/edit', [VisiMisiController::class, 'edit_misi'])->name('misi.edit_misi');
    Route::put('misi/{misi}', [VisiMisiController::class, 'update_misi'])->name('misi.update_misi');
    Route::delete('misi/{misi}', [VisiMisiController::class, 'destroy_misi'])->name('misi.destroy_misi');


    // teams
    Route::get('teams', [TeamsController::class, 'index'])->name('teams.index');
    Route::get('teams/create', [TeamsController::class, 'create'])->name('teams.create');
    Route::post('teams', [TeamsController::class, 'store'])->name('teams.store');
    Route::get('teams/{team}/edit', [TeamsController::class, 'edit'])->name('teams.edit');
    Route::put('teams/{team}', [TeamsController::class, 'update'])->name('pages.teams.update');
    Route::delete('teams/{team}', [TeamsController::class, 'destroy'])->name('teams.destroy');

    // FAQ
    Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('faq', [FaqController::class, 'store'])->name('faq.store');
    Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::put('faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');

    //contact
    Route::get('/contact', [ContactController::class, 'index']);
    Route::post('contact/mark-all-read', [ContactController::class, 'markAllRead'])->name('contact.markAllRead');
    Route::delete('contact/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');


    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('pages.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('pages.profile.update');

   Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
   Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
   Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
   Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
   Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
   Route::put('/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
   Route::delete('/pegawai/{id}/destroy', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

   //Absensi
   Route::get('/rekapabsensi', [AbsensiController::class, 'index'])->name('absensi.index');


   // Jadwal
   Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
   Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
   Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
   Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
   Route::put('/jadwal/{id}/update', [JadwalController::class, 'update'])->name('jadwal.update');
   Route::delete('/jadwal/{id}/destroy', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Jabatan
    Route::get('/jabatan', [ProfileController::class, 'jabatanIndex'])->name('jabatan.index');
    Route::get('/jabatan/create', [ProfileController::class, 'jabatanCreate'])->name('jabatan.create');
    Route::post('/jabatan/store', [ProfileController::class, 'jabatanStore'])->name('jabatan.store');
    Route::get('/jabatan/{id}/edit', [ProfileController::class, 'jabatanEdit'])->name('jabatan.edit');
    Route::put('/jabatan/{id}', [ProfileController::class, 'jabatanUpdate'])->name('jabatan.update');
    Route::delete('/jabatan/{id}', [ProfileController::class, 'jabatanDestroy'])->name('jabatan.destroy');


    // Departemen
    Route::get('/departemen', [ProfileController::class, 'departemenIndex'])->name('departemen.index');
    Route::get('/departemen/create', [ProfileController::class, 'departemenCreate'])->name('departemen.create');
    Route::post('/departemen/store', [ProfileController::class, 'departemenStore'])->name('departemen.store');
    Route::get('/departemen/{id}/edit', [ProfileController::class, 'departemenEdit'])->name('departemen.edit');
    Route::put('/departemen/{id}', [ProfileController::class, 'departemenUpdate'])->name('departemen.update');
    Route::delete('/departemen/{id}', [ProfileController::class, 'departemenDestroy'])->name('departemen.destroy');


    // Cuti
    Route::get('/cuti',[CutiController::class, 'indexAdmin'])->name('cuti.index');
    Route::put('/cuti/setujui/{id}',[CutiController::class, 'setujui'])->name('cuti.setujui');
    Route::put('/cuti/tolak/{id}',[CutiController::class, 'tolak'])->name('cuti.tolak');
    Route::get('/pengajuan', [CutiController::class, 'indexAdmin'])->name('pengajuan.index');

    // Perubahan Pegawai
    Route::get('/perubahan-pegawai',              [PerubahanPegawaiController::class, 'indexAdmin'])->name('perubahan.index');
    Route::put('/perubahan-pegawai/setujui/{id}', [PerubahanPegawaiController::class, 'setujui'])->name('perubahan.setujui');
    Route::put('/perubahan-pegawai/tolak/{id}',   [PerubahanPegawaiController::class, 'tolak'])->name('perubahan.tolak');

    // Lembur
    Route::get('/lembur', [LemburController::class, 'adminIndex'])->name('lembur.index');
    Route::get('/lembur/{id}', [LemburController::class, 'show'])->name('lembur.show');
    Route::put('/lembur/{id}/setujui', [LemburController::class, 'setujui'])->name('lembur.setujui');
    Route::put('/lembur/{id}/tolak', [LemburController::class, 'tolak'])->name('lembur.tolak');


    // koreksi
    Route::get('pengajuan-absensi', [PengajuanAbsensiController::class, 'adminIndex'])->name('pengajuan-absensi.index');
    Route::put('pengajuan-absensi/{id}/setujui', [PengajuanAbsensiController::class, 'setujui'])->name('pengajuan-absensi.setujui');
    Route::put('pengajuan-absensi/{id}/tolak', [PengajuanAbsensiController::class, 'tolak'])->name('pengajuan-absensi.tolak');


    // pengumuman
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    //Route::get('pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
});



// authentication pages
Route::get('/signin', [UserController::class, 'signin'])->name('signin');
Route::post('/signin', [UserController::class, 'postsignin'])->middleware('throttle:5,1')->name('postsignin');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::fallback(function () {
    return response()->view('pages.errors.error-404', [], 404);
});
// Route::get('/signin', function () {
//     return view('pages.auth.signin', ['title' => 'Sign In']);
// })->name('signin');

// Route::post('/postsignin', function () {
//     return view('pages.auth.signin', ['title' => 'Sign In']);
// })->name('postsignin');

// Route::get('/signup', function () {
//     return view('pages.auth.signup', ['title' => 'Sign Up']);
// })->name('signup');























