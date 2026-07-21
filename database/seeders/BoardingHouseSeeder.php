<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Owner;
use App\Models\Tenant;
use App\Models\BoardingHouse;
use App\Models\BoardingHousePhoto;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BoardingHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan roles ada
        $this->ensureRolesExist();

        // Data Owners (5 owner)
        $owners = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@kostmudah.com',
                'phone' => '081234567890',
                'verification_status' => 'approved',
                'verification_document' => 'documents/ktp_budi.pdf',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@kostmudah.com',
                'phone' => '081234567891',
                'verification_status' => 'approved',
                'verification_document' => 'documents/ktp_siti.pdf',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@kostmudah.com',
                'phone' => '081234567892',
                'verification_status' => 'approved',
                'verification_document' => 'documents/ktp_andi.pdf',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@kostmudah.com',
                'phone' => '081234567893',
                'verification_status' => 'pending',
                'verification_document' => 'documents/ktp_dewi.pdf',
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi@kostmudah.com',
                'phone' => '081234567894',
                'verification_status' => 'approved',
                'verification_document' => 'documents/ktp_rudi.pdf',
            ],
        ];

        // Data Boarding Houses (5 kost)
        $boardingHouses = [
            [
                'name' => 'Kost Mawar Indah',
                'address' => 'Jl. Mawar No. 12, Tebet, Jakarta Selatan',
                'kelurahan' => 'Tebet',
                'latitude' => -6.2389,
                'longitude' => 106.8505,
                'type' => 'putri',
                'price_per_month' => 1500000,
                'total_rooms' => 10,
                'available_rooms' => 5,
                'description' => 'Kost nyaman dengan suasana asri dan tenang, cocok untuk mahasiswa dan pekerja.',
                'rules' => "1. Dilarang membawa tamu lawan jenis menginap\n2. Jam malam pukul 23.00 WIB\n3. Dilarang merokok di dalam kamar\n4. Jaga kebersihan lingkungan kost",
                'facilities' => ['WiFi', 'AC', 'KM Dalam', 'Dapur Umum', 'Parkir Motor', 'Laundry', 'Lemari', 'Meja Belajar'],
                'owner_email' => 'budi@kostmudah.com',
                'status' => 'active',
            ],
            [
                'name' => 'Kost Green Terrace',
                'address' => 'Jl. Hijau No. 45, Menteng, Jakarta Pusat',
                'kelurahan' => 'Menteng',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'type' => 'putra',
                'price_per_month' => 2750000,
                'total_rooms' => 8,
                'available_rooms' => 3,
                'description' => 'Kost premium dengan view taman hijau dan fasilitas lengkap.',
                'rules' => "1. Dilarang membawa hewan peliharaan\n2. Jam malam pukul 22.00 WIB\n3. Dilarang merokok di dalam kamar\n4. Jaga ketenangan lingkungan",
                'facilities' => ['WiFi', 'AC', 'KM Dalam', 'Parkir Mobil', 'Laundry', 'Lemari', 'TV', 'Kulkas'],
                'owner_email' => 'siti@kostmudah.com',
                'status' => 'active',
            ],
            [
                'name' => 'Kost Cempaka Blue',
                'address' => 'Jl. Cempaka No. 78, Kuningan, Jakarta Selatan',
                'kelurahan' => 'Kuningan',
                'latitude' => -6.2275,
                'longitude' => 106.8312,
                'type' => 'campur',
                'price_per_month' => 4200000,
                'total_rooms' => 12,
                'available_rooms' => 7,
                'description' => 'Kost eksklusif di area bisnis dengan akses mudah ke berbagai tempat.',
                'rules' => "1. Tamu wajib lapor ke pengelola\n2. Jam malam pukul 24.00 WIB\n3. Dilarang merokok di area kost\n4. Jaga kebersihan dan ketertiban",
                'facilities' => ['WiFi', 'AC', 'KM Dalam', 'Parkir Mobil', 'Laundry', 'Lemari', 'Meja Belajar', 'Air Panas', 'Kulkas'],
                'owner_email' => 'andi@kostmudah.com',
                'status' => 'active',
            ],
            [
                'name' => 'Kost Kemanggisan',
                'address' => 'Jl. Kemanggisan No. 23, Kemanggisan, Jakarta Barat',
                'kelurahan' => 'Kemanggisan',
                'latitude' => -6.1795,
                'longitude' => 106.7805,
                'type' => 'putri',
                'price_per_month' => 900000,
                'total_rooms' => 15,
                'available_rooms' => 10,
                'description' => 'Kost terjangkau dengan lingkungan yang aman dan nyaman untuk mahasiswa.',
                'rules' => "1. Dilarang membawa tamu menginap\n2. Jam malam pukul 21.00 WIB\n3. Dilarang merokok di dalam area kost\n4. Jaga kebersihan bersama",
                'facilities' => ['WiFi', 'KM Dalam', 'Dapur Umum', 'Parkir Motor', 'Lemari', 'Meja Belajar'],
                'owner_email' => 'dewi@kostmudah.com',
                'status' => 'active',
            ],
            [
                'name' => 'Kost Grogol Indah',
                'address' => 'Jl. Grogol No. 56, Grogol, Jakarta Barat',
                'kelurahan' => 'Grogol',
                'latitude' => -6.1658,
                'longitude' => 106.7865,
                'type' => 'campur',
                'price_per_month' => 1850000,
                'total_rooms' => 10,
                'available_rooms' => 5,
                'description' => 'Kost modern dengan fasilitas lengkap dan akses transportasi mudah.',
                'rules' => "1. Dilarang membawa hewan peliharaan\n2. Jam malam pukul 23.00 WIB\n3. Dilarang merokok di dalam kamar\n4. Jaga kebersihan dan ketertiban",
                'facilities' => ['WiFi', 'AC', 'KM Dalam', 'Parkir Motor', 'Laundry', 'Lemari', 'Air Panas', 'TV'],
                'owner_email' => 'rudi@kostmudah.com',
                'status' => 'active',
            ],
        ];

        // Data Tenants (5 tenant per kost = 25 tenant)
        $tenantsData = [
            // ============ KOST MAWAR INDAH (Putri) ============
            [
                'name' => 'Ayu Maharani',
                'email' => 'ayu@email.com',
                'phone' => '081234567901',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Mawar Indah',
                'room_number' => 'A-101',
                'start_date' => '2024-01-15',
                'end_date' => '2025-01-15',
                'duration_months' => 12,
                'total_price' => 18000000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran sewa bulan Januari 2024',
            ],
            [
                'name' => 'Sari Utami',
                'email' => 'sari@email.com',
                'phone' => '081234567902',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Mawar Indah',
                'room_number' => 'A-102',
                'start_date' => '2024-02-01',
                'end_date' => '2025-02-01',
                'duration_months' => 12,
                'total_price' => 18000000,
                'payment_status' => 'pending',
                'payment_method' => 'qris',
                'payment_notes' => 'Menunggu konfirmasi pembayaran',
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya@email.com',
                'phone' => '081234567903',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Mawar Indah',
                'room_number' => 'A-103',
                'start_date' => '2024-03-10',
                'end_date' => '2025-03-10',
                'duration_months' => 12,
                'total_price' => 18000000,
                'payment_status' => 'verified',
                'payment_method' => 'ewallet',
                'payment_notes' => 'Pembayaran via E-Wallet',
            ],
            [
                'name' => 'Rina Melati',
                'email' => 'rina@email.com',
                'phone' => '081234567904',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Mawar Indah',
                'room_number' => 'A-104',
                'start_date' => '2024-04-05',
                'end_date' => '2025-04-05',
                'duration_months' => 12,
                'total_price' => 18000000,
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Menunggu bukti transfer',
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.ten@email.com',
                'phone' => '081234567905',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Mawar Indah',
                'room_number' => 'A-105',
                'start_date' => '2024-05-20',
                'end_date' => '2025-05-20',
                'duration_months' => 12,
                'total_price' => 18000000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran via transfer bank',
            ],

            // ============ KOST GREEN TERRACE (Putra) ============
            [
                'name' => 'Andi Saputra',
                'email' => 'andi.s@email.com',
                'phone' => '081234567906',
                'occupation' => 'Karyawan',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Green Terrace',
                'room_number' => 'B-201',
                'start_date' => '2024-01-20',
                'end_date' => '2025-01-20',
                'duration_months' => 12,
                'total_price' => 33000000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran sewa bulan Januari',
            ],
            [
                'name' => 'Budi Pratama',
                'email' => 'budi.p@email.com',
                'phone' => '081234567907',
                'occupation' => 'Mahasiswa',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Green Terrace',
                'room_number' => 'B-202',
                'start_date' => '2024-02-15',
                'end_date' => '2025-02-15',
                'duration_months' => 12,
                'total_price' => 33000000,
                'payment_status' => 'pending',
                'payment_method' => 'qris',
                'payment_notes' => 'Menunggu pembayaran via QRIS',
            ],
            [
                'name' => 'Cahya Nugraha',
                'email' => 'cahya@email.com',
                'phone' => '081234567908',
                'occupation' => 'Karyawan',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Green Terrace',
                'room_number' => 'B-203',
                'start_date' => '2024-03-01',
                'end_date' => '2025-03-01',
                'duration_months' => 12,
                'total_price' => 33000000,
                'payment_status' => 'verified',
                'payment_method' => 'ewallet',
                'payment_notes' => 'Pembayaran via E-Wallet',
            ],
            [
                'name' => 'Deni Ramdani',
                'email' => 'deni@email.com',
                'phone' => '081234567909',
                'occupation' => 'Mahasiswa',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Green Terrace',
                'room_number' => 'B-204',
                'start_date' => '2024-04-10',
                'end_date' => '2025-04-10',
                'duration_months' => 12,
                'total_price' => 33000000,
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Menunggu bukti transfer',
            ],
            [
                'name' => 'Eko Susanto',
                'email' => 'eko@email.com',
                'phone' => '081234567910',
                'occupation' => 'Karyawan',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Green Terrace',
                'room_number' => 'B-205',
                'start_date' => '2024-05-05',
                'end_date' => '2025-05-05',
                'duration_months' => 12,
                'total_price' => 33000000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran via transfer',
            ],

            // ============ KOST CEMPAKA BLUE (Campur) ============
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri@email.com',
                'phone' => '081234567911',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Cempaka Blue',
                'room_number' => 'C-301',
                'start_date' => '2024-01-10',
                'end_date' => '2025-01-10',
                'duration_months' => 12,
                'total_price' => 50400000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran sewa bulan Januari',
            ],
            [
                'name' => 'Gilang Purnama',
                'email' => 'gilang@email.com',
                'phone' => '081234567912',
                'occupation' => 'Wirausaha',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Cempaka Blue',
                'room_number' => 'C-302',
                'start_date' => '2024-02-20',
                'end_date' => '2025-02-20',
                'duration_months' => 12,
                'total_price' => 50400000,
                'payment_status' => 'pending',
                'payment_method' => 'qris',
                'payment_notes' => 'Menunggu pembayaran',
            ],
            [
                'name' => 'Hana Kartika',
                'email' => 'hana@email.com',
                'phone' => '081234567913',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Cempaka Blue',
                'room_number' => 'C-303',
                'start_date' => '2024-03-15',
                'end_date' => '2025-03-15',
                'duration_months' => 12,
                'total_price' => 50400000,
                'payment_status' => 'verified',
                'payment_method' => 'ewallet',
                'payment_notes' => 'Pembayaran via E-Wallet',
            ],
            [
                'name' => 'Irfan Maulana',
                'email' => 'irfan@email.com',
                'phone' => '081234567914',
                'occupation' => 'Karyawan',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Cempaka Blue',
                'room_number' => 'C-304',
                'start_date' => '2024-04-01',
                'end_date' => '2025-04-01',
                'duration_months' => 12,
                'total_price' => 50400000,
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Menunggu transfer',
            ],
            [
                'name' => 'Jihan Puspita',
                'email' => 'jihan@email.com',
                'phone' => '081234567915',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Cempaka Blue',
                'room_number' => 'C-305',
                'start_date' => '2024-05-20',
                'end_date' => '2025-05-20',
                'duration_months' => 12,
                'total_price' => 50400000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran via transfer',
            ],

            // ============ KOST KEMANGGISAN (Putri) ============
            [
                'name' => 'Karina Putri',
                'email' => 'karina@email.com',
                'phone' => '081234567916',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Kemanggisan',
                'room_number' => 'D-401',
                'start_date' => '2024-01-05',
                'end_date' => '2025-01-05',
                'duration_months' => 12,
                'total_price' => 10800000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran sewa',
            ],
            [
                'name' => 'Laras Aulia',
                'email' => 'laras@email.com',
                'phone' => '081234567917',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Kemanggisan',
                'room_number' => 'D-402',
                'start_date' => '2024-02-10',
                'end_date' => '2025-02-10',
                'duration_months' => 12,
                'total_price' => 10800000,
                'payment_status' => 'pending',
                'payment_method' => 'qris',
                'payment_notes' => 'Menunggu pembayaran',
            ],
            [
                'name' => 'Mega Wati',
                'email' => 'mega@email.com',
                'phone' => '081234567918',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Kemanggisan',
                'room_number' => 'D-403',
                'start_date' => '2024-03-20',
                'end_date' => '2025-03-20',
                'duration_months' => 12,
                'total_price' => 10800000,
                'payment_status' => 'verified',
                'payment_method' => 'ewallet',
                'payment_notes' => 'Pembayaran via E-Wallet',
            ],
            [
                'name' => 'Nina Ardianti',
                'email' => 'nina@email.com',
                'phone' => '081234567919',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Kemanggisan',
                'room_number' => 'D-404',
                'start_date' => '2024-04-15',
                'end_date' => '2025-04-15',
                'duration_months' => 12,
                'total_price' => 10800000,
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Menunggu transfer',
            ],
            [
                'name' => 'Oktavia Dewi',
                'email' => 'oktavia@email.com',
                'phone' => '081234567920',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Kemanggisan',
                'room_number' => 'D-405',
                'start_date' => '2024-05-25',
                'end_date' => '2025-05-25',
                'duration_months' => 12,
                'total_price' => 10800000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran via transfer',
            ],

            // ============ KOST GROGOL INDAH (Campur) ============
            [
                'name' => 'Pandu Wijaya',
                'email' => 'pandu@email.com',
                'phone' => '081234567921',
                'occupation' => 'Karyawan',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Grogol Indah',
                'room_number' => 'E-501',
                'start_date' => '2024-01-25',
                'end_date' => '2025-01-25',
                'duration_months' => 12,
                'total_price' => 22200000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran sewa',
            ],
            [
                'name' => 'Qori Azizah',
                'email' => 'qori@email.com',
                'phone' => '081234567922',
                'occupation' => 'Mahasiswa',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Grogol Indah',
                'room_number' => 'E-502',
                'start_date' => '2024-02-25',
                'end_date' => '2025-02-25',
                'duration_months' => 12,
                'total_price' => 22200000,
                'payment_status' => 'pending',
                'payment_method' => 'qris',
                'payment_notes' => 'Menunggu pembayaran',
            ],
            [
                'name' => 'Raka Satria',
                'email' => 'raka@email.com',
                'phone' => '081234567923',
                'occupation' => 'Wirausaha',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Grogol Indah',
                'room_number' => 'E-503',
                'start_date' => '2024-03-05',
                'end_date' => '2025-03-05',
                'duration_months' => 12,
                'total_price' => 22200000,
                'payment_status' => 'verified',
                'payment_method' => 'ewallet',
                'payment_notes' => 'Pembayaran via E-Wallet',
            ],
            [
                'name' => 'Sinta Meilani',
                'email' => 'sinta@email.com',
                'phone' => '081234567924',
                'occupation' => 'Karyawan',
                'gender' => 'P',
                'boarding_house_name' => 'Kost Grogol Indah',
                'room_number' => 'E-504',
                'start_date' => '2024-04-20',
                'end_date' => '2025-04-20',
                'duration_months' => 12,
                'total_price' => 22200000,
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Menunggu transfer',
            ],
            [
                'name' => 'Teguh Kurniawan',
                'email' => 'teguh@email.com',
                'phone' => '081234567925',
                'occupation' => 'Mahasiswa',
                'gender' => 'L',
                'boarding_house_name' => 'Kost Grogol Indah',
                'room_number' => 'E-505',
                'start_date' => '2024-05-10',
                'end_date' => '2025-05-10',
                'duration_months' => 12,
                'total_price' => 22200000,
                'payment_status' => 'verified',
                'payment_method' => 'bank_transfer',
                'payment_notes' => 'Pembayaran via transfer',
            ],
        ];

        // ============================================================
        // PROSES SEEDING
        // ============================================================

        $this->command->info("\n🚀 Starting seeding process...\n");

        // 1. Buat Owners
        $this->command->info("📌 Creating Owners...");
        $createdOwners = [];
        foreach ($owners as $ownerData) {
            $user = User::where('email', $ownerData['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $ownerData['name'],
                    'email' => $ownerData['email'],
                    'phone' => $ownerData['phone'],
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('owner');
                $this->command->info("   ✅ Owner '{$ownerData['name']}' created!");
            } else {
                $this->command->warn("   ⚠️ Owner '{$ownerData['name']}' already exists.");
            }

            $owner = Owner::where('user_id', $user->id)->first();
            if (!$owner) {
                Owner::create([
                    'user_id' => $user->id,
                    'verification_document' => $ownerData['verification_document'],
                    'verification_status' => $ownerData['verification_status'],
                    'verified_at' => $ownerData['verification_status'] === 'approved' ? now() : null,
                ]);
                $this->command->info("   ✅ Owner record created for '{$user->name}'");
            }
            
            $createdOwners[$user->email] = $user;
        }

        // 2. Buat Boarding Houses
        $this->command->info("\n📌 Creating Boarding Houses...");
        $createdBoardingHouses = [];
        foreach ($boardingHouses as $bhData) {
            $owner = $createdOwners[$bhData['owner_email']] ?? null;
            
            if (!$owner) {
                $this->command->warn("   ⚠️ Owner not found for {$bhData['name']}, skipping...");
                continue;
            }

            $boardingHouse = BoardingHouse::create([
                'user_id' => $owner->id,
                'slug' => Str::slug($bhData['name']) . '-' . time() . '-' . Str::random(6),
                'name' => $bhData['name'],
                'address' => $bhData['address'],
                'kelurahan' => $bhData['kelurahan'],
                'latitude' => $bhData['latitude'],
                'longitude' => $bhData['longitude'],
                'type' => $bhData['type'],
                'price_per_month' => $bhData['price_per_month'],
                'total_rooms' => $bhData['total_rooms'],
                'available_rooms' => $bhData['available_rooms'],
                'description' => $bhData['description'],
                'rules' => $bhData['rules'],
                'facilities' => $bhData['facilities'],
                'status' => $bhData['status'],
            ]);

            // Buat foto contoh (3 foto per kost)
            $photoPaths = [
                'boarding-houses/sample1.jpg',
                'boarding-houses/sample2.jpg',
                'boarding-houses/sample3.jpg',
            ];

            foreach ($photoPaths as $key => $path) {
                BoardingHousePhoto::create([
                    'boarding_house_id' => $boardingHouse->id,
                    'path' => $path,
                    'is_primary' => $key === 0,
                ]);
            }

            $createdBoardingHouses[$bhData['name']] = $boardingHouse;
            $this->command->info("   ✅ Boarding House '{$bhData['name']}' created!");
        }

        // 3. Buat Tenants, Rentals, dan Payments
        $this->command->info("\n📌 Creating Tenants, Rentals, and Payments...");
        $totalTenants = count($tenantsData);
        $counter = 0;
        
        foreach ($tenantsData as $tenantData) {
            $counter++;
            $boardingHouse = $createdBoardingHouses[$tenantData['boarding_house_name']] ?? null;
            
            if (!$boardingHouse) {
                $this->command->warn("   ⚠️ Boarding house not found for {$tenantData['name']}, skipping...");
                continue;
            }

            // Buat User Tenant
            $user = User::where('email', $tenantData['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $tenantData['name'],
                    'email' => $tenantData['email'],
                    'phone' => $tenantData['phone'],
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('tenant');
                $this->command->info("   ✅ [$counter/$totalTenants] Tenant User '{$tenantData['name']}' created!");
            } else {
                $this->command->warn("   ⚠️ Tenant User '{$tenantData['name']}' already exists.");
            }

            // Buat Tenant
            $tenant = Tenant::where('user_id', $user->id)->first();
            if (!$tenant) {
                $tenant = Tenant::create([
                    'user_id' => $user->id,
                    'occupation' => $tenantData['occupation'],
                    'gender' => $tenantData['gender'],
                ]);
                $this->command->info("   ✅ Tenant record created for '{$user->name}'");
            }

            // Buat Rental
            $rentalStatus = $tenantData['payment_status'] === 'verified' ? 'paid' : 'pending';
            
            $rental = Rental::create([
                'tenant_id' => $tenant->id,
                'boarding_house_id' => $boardingHouse->id,
                'room_number' => $tenantData['room_number'],
                'start_date' => $tenantData['start_date'],
                'end_date' => $tenantData['end_date'],
                'duration_months' => $tenantData['duration_months'],
                'total_price' => $tenantData['total_price'],
                'unique_code' => Rental::generateUniqueCode(),
                'status' => $rentalStatus,
            ]);
            $this->command->info("   ✅ Rental created for '{$user->name}' at {$boardingHouse->name} - Kamar {$tenantData['room_number']} (Status: {$rentalStatus})");

            // Buat Payment
            Payment::create([
                'rental_id' => $rental->id,
                'method' => $tenantData['payment_method'],
                'amount' => $tenantData['total_price'] / $tenantData['duration_months'],
                'proof_path' => null,
                'notes' => $tenantData['payment_notes'],
                'status' => $tenantData['payment_status'],
                'verified_at' => $tenantData['payment_status'] === 'verified' ? now() : null,
            ]);
            $this->command->info("   ✅ Payment created for '{$user->name}' - Method: {$tenantData['payment_method']}, Status: {$tenantData['payment_status']}");

            // Kurangi available rooms
            $boardingHouse->decrement('available_rooms');
        }

        // ============================================================
        // SUMMARY
        // ============================================================
        
        $this->command->info("\n✅ All data seeded successfully!");
        
        $this->command->info("\n📊 SUMMARY:");
        $this->command->info("   ┌─────────────────────────────────────────────┐");
        $this->command->info("   │  Owners           : " . str_pad(count($owners), 10, " ", STR_PAD_LEFT) . " orang        │");
        $this->command->info("   │  Boarding Houses  : " . str_pad(count($boardingHouses), 10, " ", STR_PAD_LEFT) . " properti     │");
        $this->command->info("   │  Tenants          : " . str_pad(count($tenantsData), 10, " ", STR_PAD_LEFT) . " orang        │");
        $this->command->info("   │  Rentals          : " . str_pad(count($tenantsData), 10, " ", STR_PAD_LEFT) . " unit         │");
        $this->command->info("   │  Payments         : " . str_pad(count($tenantsData), 10, " ", STR_PAD_LEFT) . " transaksi    │");
        $this->command->info("   └─────────────────────────────────────────────┘");
        
        $verifiedCount = Payment::where('status', 'verified')->count();
        $pendingCount = Payment::where('status', 'pending')->count();
        
        $this->command->info("\n   💰 Payment Status:");
        $this->command->info("   ✅ Verified : " . $verifiedCount . " transaksi");
        $this->command->info("   ⏳ Pending  : " . $pendingCount . " transaksi");
        
        $this->command->info("\n🔑 Login Credentials:");
        $this->command->info("   Owner  : budi@kostmudah.com / password123");
        $this->command->info("   Tenant : ayu@email.com / password123");
        $this->command->info("   Admin  : admin@kostmudah.com / password123");
        $this->command->info("\n✅ Done!");
    }

    /**
     * Ensure all roles exist.
     */
    private function ensureRolesExist(): void
    {
        $roles = ['admin', 'owner', 'tenant'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
        $this->command->info('✅ Roles ensured!');
    }
}   