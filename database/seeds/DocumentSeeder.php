<?php

use Illuminate\Database\Seeder;
use App\Models\Document;
class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
  
   
            $document= [
                ///1////
               ['name' => 'Mathématiques', 'nombre_page'=>130,'pdf'=>'/pdf/1p.pdf','manuel_id'=>'405'],
               ////2sc/////
               ['name' => 'Mathématiques', 'nombre_page'=>164,'pdf'=>'/pdf/2s.pdf','manuel_id'=>'419'],
               //3sc///
               ['name' => 'Mathématiques', 'nombre_page'=>192,'pdf'=>'/pdf/3s.pdf','manuel_id'=>'472'],
               //4math///
               ['name' => 'Mathématiques', 'nombre_page'=>207,'pdf'=>'/pdf/t1.pdf','manuel_id'=>'552'],
            ];
            foreach ($document as $key => $value) {
    
                document::create($value);
          
              }
        }
    
    
}
