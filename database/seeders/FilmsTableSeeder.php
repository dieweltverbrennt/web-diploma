<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Film;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('films')->insert([
            [
                'name' => 'Звёздные войны XXIII: Атака клонированных клонов',
                'description' => 'Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.',
                'production_country'=> 'США',
                'duration' => '130 минут',
                'path_to_image' => 'poster1.jpg'
            ],
            [
                'name' => 'Альфа',
                'description' => '20 тысяч лет назад Земля была холодным и неуютным местом, в котором смерть подстерегала человека на каждом шагу.',
                'production_country'=> 'Франция',
                'duration' => '96 минут',
                'path_to_image' => 'poster2.jpg'
            ],
            [
                'name' => 'Хищник',
                'description' => 'Самые опасные хищники Вселенной, прибыв из глубин космоса, высаживаются на улицах маленького городка, чтобы начать свою кровавую охоту. Генетически модернизировав себя с помощью ДНК других видов, охотники стали ещё сильнее, умнее и беспощаднее.',
                'production_country'=> 'Канада, США',
                'duration' => '101 минута',
                'path_to_image' => 'poster2.jpg'
            ]
        ]);
    }
}
