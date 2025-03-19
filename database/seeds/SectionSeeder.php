<?php

use Illuminate\Database\Seeder;
use App\Models\SectionMat;

class SectionSeeder extends Seeder
{

        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $section = [
    
              
    
    
    
                ['name' => 'Science','level_id'=>'2'],
                ['name' => 'Technique','level_id'=>'2'],
                ['name' => 'Lettre','level_id'=>'2'],
                ['name' => 'Informatique','level_id'=>'2'],
                ['name' => 'Economie','level_id'=>'2'], 
                
                 
                ['name' => 'Science','level_id'=>'3'],
                ['name' => 'Mathématique','level_id'=>'3'],
                ['name' => 'Technique','level_id'=>'3'],
                ['name' => 'Lettre','level_id'=>'3'],
                ['name' => 'Informatique','level_id'=>'3'],
                ['name' => 'Economie','level_id'=>'3'],
                 
                ['name' => 'Science','level_id'=>'4'],
                ['name' => 'Mathématique','level_id'=>'4'],
                ['name' => 'Technique','level_id'=>'4'],
                ['name' => 'Lettre','level_id'=>'4'],
                ['name' => 'Informatique','level_id'=>'4'],
                ['name' => 'Economie','level_id'=>'4'],
                 
                 
    
    
              
            ];
            foreach ($section as $key => $value) {
    
                SectionMat::create($value);
    
            }
        }
    
    
    
    
}
