<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = ['ابتدائي' ,'متوسط' ,'ثانوي' , 'مجمع'];
        for ($i=0; $i < 4; $i++) {
            Level::create([
                'name' => $levels[$i]
            ]);
        }
    }
}
