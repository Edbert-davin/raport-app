<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Aspect;
use App\Models\SubIndicator;
use App\Models\DescriptionTemplate;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Dummy Guru
        User::create([
            'name' => 'Ibu Guru Ani',
            'email' => 'guru@paud.com',
            'password' => Hash::make('password123'),
            'role' => 'guru'
        ]);

        // 2. Buat Akun Dummy Murid/Orang Tua
        $akunBudi = User::create([
            'name' => 'Orang Tua Budi',
            'email' => 'budi@paud.com',
            'password' => Hash::make('password123'),
            'role' => 'murid'
        ]);

        $akunSiti = User::create([
            'name' => 'Orang Tua Siti',
            'email' => 'siti@paud.com',
            'password' => Hash::make('password123'),
            'role' => 'murid'
        ]);

        // 3. Setup Kelas dan Siswa (hubungkan dengan user_id)
        $class = Classroom::create(['name' => 'TK A (Matahari)', 'school_year' => '2023/2024']);
        
        Student::create([
            'user_id' => $akunBudi->id,
            'classroom_id' => $class->id, 
            'name' => 'Budi Santoso', 
            'nickname' => 'Budi', 
            'gender' => 'L'
        ]);
        
        Student::create([
            'user_id' => $akunSiti->id,
            'classroom_id' => $class->id, 
            'name' => 'Siti Aminah', 
            'nickname' => 'Siti', 
            'gender' => 'P'
        ]);

        // 4. Setup Aspek, Sub-Indikator, dan Template Deskripsi (Sama persis seperti sebelumnya)
        $aspects = [
            'Nilai Agama dan Moral' => ['Terbiasa mengucapkan doa sehari-hari', 'Mengenal perilaku baik dan santun'],
            'Motorik' => ['Mampu melompat dengan dua kaki (Kasar)', 'Mampu memegang pensil dengan benar (Halus)'],
            'Kognitif' => ['Mengenal lambang bilangan 1-10', 'Mampu mengelompokkan benda berdasarkan warna'],
            'Bahasa' => ['Mampu menceritakan kembali cerita sederhana', 'Menjawab pertanyaan dengan kalimat yang benar']
        ];

        foreach ($aspects as $aspectName => $indicators) {
            $aspect = Aspect::create(['name' => $aspectName]);
            foreach ($indicators as $ind) {
                SubIndicator::create(['aspect_id' => $aspect->id, 'description' => $ind]);
            }

            DescriptionTemplate::create(['aspect_id' => $aspect->id, 'scale' => 'BSH', 'template_text' => 'Alhamdulillah, {nama} berkembang sesuai harapan. {panggilan} sudah menunjukkan kemampuan yang baik dalam pembelajaran di kelas.']);
            DescriptionTemplate::create(['aspect_id' => $aspect->id, 'scale' => 'BSB', 'template_text' => 'Luar biasa! {nama} berkembang sangat baik. {panggilan} sangat antusias dan mandiri dalam menguasai materi pembelajaran.']);
            DescriptionTemplate::create(['aspect_id' => $aspect->id, 'scale' => 'MB', 'template_text' => '{nama} mulai berkembang. {panggilan} masih membutuhkan sedikit bimbingan dan motivasi untuk lebih berani mencoba.']);
            DescriptionTemplate::create(['aspect_id' => $aspect->id, 'scale' => 'BB', 'template_text' => '{nama} belum berkembang optimal. Diperlukan pendampingan lebih intensif bagi {panggilan} baik di sekolah maupun pengulangan di rumah.']);
        }
    }
}