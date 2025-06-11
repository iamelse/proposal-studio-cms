<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Kak Nunung',
                'rating' => 5,
                'comment' => 'Kakaknya baik sekali, sabar menghadapi customer. Untuk pengerjaan cepat dan halus...',
                'company_name' => 'Finalis Miss Hijab Indonesia 2022',
                'image' => 'https://ui-avatars.com/api/?name=Kak+Nunung&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kak Ade',
                'rating' => 5,
                'comment' => 'Ini udah kali ketiganya pakai Proposal Studio...',
                'company_name' => 'Atlet Badminton Top 11 National Rank',
                'image' => 'https://ui-avatars.com/api/?name=Kak+Ade&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kak Tatang',
                'rating' => 5,
                'comment' => 'Pelayanannya sangat memuaskan dan cepat tanggap!',
                'company_name' => 'Duta Literasi Indonesia',
                'image' => 'https://ui-avatars.com/api/?name=Kak+Tatang&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Trend Coffee',
                'rating' => 5,
                'comment' => 'Proposalnya sangat profesional dan tepat waktu.',
                'company_name' => 'Trend Coffee',
                'image' => 'https://ui-avatars.com/api/?name=Trend+Coffee&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => "Majelis Ta'lim",
                'rating' => 4.5,
                'comment' => 'Desainnya bagus, pengerjaan cepat. Terima kasih!',
                'company_name' => "Majelis Ta'lim Bustanul Wildan",
                'image' => 'https://ui-avatars.com/api/?name=Majelis+Ta\'lim&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'CV Kutai Media',
                'rating' => 5,
                'comment' => 'Sangat puas dengan hasil proposal yang diberikan.',
                'company_name' => 'CV Kutai Media Utama',
                'image' => 'https://ui-avatars.com/api/?name=Kutai+Media&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Hackfest 2023',
                'rating' => 5,
                'comment' => 'Proposalnya keren dan proses pengerjaan cepat.',
                'company_name' => 'Hackfest 2023',
                'image' => 'https://ui-avatars.com/api/?name=Hackfest+2023&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pak Paulus',
                'rating' => 5,
                'comment' => 'Makasih Proposal Studio, hasilnya sangat memuaskan.',
                'company_name' => 'Project Batu Bara & Kayu',
                'image' => 'https://ui-avatars.com/api/?name=Pak+Paulus&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'IM3 Denpasar',
                'rating' => 5,
                'comment' => 'Proposal sangat sesuai dengan kebutuhan event kami.',
                'company_name' => 'IM3 Denpasar Bali',
                'image' => 'https://ui-avatars.com/api/?name=IM3+Denpasar&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Neko Esport',
                'rating' => 5,
                'comment' => 'Desainnya keren dan sesuai request. Recommended!',
                'company_name' => 'Neko Esport',
                'image' => 'https://ui-avatars.com/api/?name=Neko+Esport&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Baby Ourlens',
                'rating' => 5,
                'comment' => 'Konsep proposalnya mantap, cepat dan tepat!',
                'company_name' => 'Baby Ourlens Kediri',
                'image' => 'https://ui-avatars.com/api/?name=Baby+Ourlens&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Camp Naga Sakti',
                'rating' => 5,
                'comment' => 'Desain menarik, service cepat dan ramah.',
                'company_name' => 'Pelatihan Muay Thai dan Boxing',
                'image' => 'https://ui-avatars.com/api/?name=Naga+Sakti&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'HAMN 2022',
                'rating' => 5,
                'comment' => 'Revisi cepat, hasil sangat memuaskan!',
                'company_name' => 'Macroworldmania',
                'image' => 'https://ui-avatars.com/api/?name=HAMN+2022&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sapta Mahifal',
                'rating' => 5,
                'comment' => 'Fast respon dan hasil luar biasa. Terbaik!',
                'company_name' => 'Sapta Mahifal Corporate',
                'image' => 'https://ui-avatars.com/api/?name=Sapta+Mahifal&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Relawan Banjarnegara',
                'rating' => 5,
                'comment' => 'Proposalnya keren semua, sukses terus!',
                'company_name' => 'Relawan Banjarnegara Atas',
                'image' => 'https://ui-avatars.com/api/?name=Relawan+Banjarnegara&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Ve House Solo',
                'rating' => 5,
                'comment' => 'Semua aspek dalam proposal sangat bagus.',
                'company_name' => 'Ve House of Beauty Solo',
                'image' => 'https://ui-avatars.com/api/?name=Ve+House+Solo&background=random',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('reviews')->insert($reviews);
    }
}
