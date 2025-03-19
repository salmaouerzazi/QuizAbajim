<?php

use Illuminate\Database\Seeder;
use App\Models\School_level;

class School_levelSeeder extends Seeder
{
   

        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
           //School_level::truncate();
     
      
    
            $school_levels = [
    
                ['name' => 'Première '],
    
                ['name' => 'Deuxième '],
    
                ['name' => 'Troisième '],
    
                ['name' => 'baccalauréat'],
    
               
            ];
            foreach ($school_levels as $key => $value) {
    
                School_level::create($value);
    
            }
        }
    
    
}
