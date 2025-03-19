<?php

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $option = [
    
                ['name' => 'Italien','logo'=>'/option/italien.jpeg','pdf'=>'/option/italien_3eme.pdf','video'=>'/option/it3.mp4','niveau'=>'3'],
                ['name' => 'Italien','logo'=>'/option/italien4.jpeg','pdf'=>'/option/Italien_4eme.pdf','video'=>'/option/it4.mp4','niveau'=>'4'],
                ['name' => 'Allemand','logo'=>'/option/allemand.jpeg','pdf'=>'/option/almand_3eme.pdf','video'=>'/option/al3.mp4','niveau'=>'3'],
                ['name' => 'Allemand','logo'=>'/option/allemandbac.jpeg','pdf'=>'/option/allmand_4eme_1.pdf','video'=>'/option/al4.mp4','niveau'=>'4'],
                ['name' => 'Ispagnol','logo'=>'/option/ispagnol.jpeg','pdf'=>'/option/espaniol_3eme.pdf','video'=>'/option/es1.mp4','niveau'=>'3'],
                ['name' => 'Ispagnol','logo'=>'/option/ispagnol4.jpeg','pdf'=>'/option/espagnol_4eme.pdf','video'=>'/option/es2.mp4','niveau'=>'4'],
                ['name' => 'Chinois','logo'=>'/option/chinois.jpeg','pdf'=>'/option/chinois_3eme.pdf','video'=>'/option/ch1.mp4','niveau'=>'3'],
                ['name' => 'Chinois','logo'=>'/option/chinois4.jpeg','pdf'=>'/option/chinois_4eme.pdf','video'=>'/option/ch2.mp4','niveau'=>'4'],
                ['name' => 'Science','logo'=>'/option/science.jpeg','pdf'=>'/option/svt_3L.pdf','niveau'=>'3'],
                ['name' => 'Science','logo'=>'/option/science4.jpeg','pdf'=>'/option/svt_4L.pdf','niveau'=>'4'],
                ['name' => 'Dessin','niveau'=>'3'],
                ['name' => 'Dessin','niveau'=>'4'],
                ['name' => 'Musique','niveau'=>'3'],
                ['name' => 'Musique','niveau'=>'4'],
                ['name' => 'Théâtre','niveau'=>'3'],
                ['name' => 'Théâtre','niveau'=>'4'],
    ];
            foreach ($option as $key => $value) {
    
                Option::create($value);
    
            }
        }
    
    
}
