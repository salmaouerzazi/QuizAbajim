<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $video= [
            ///1////
           ['titre' => 'Espace vectoriel','video'=>'/video/p1.mp4','manuel_id'=>'405'],
           ['titre' => 'Continuité et limite','video'=>'/video/2s.mp4','manuel_id'=>'405'],
           ['titre' => 'Dérivé et Primitive','video'=>'/video/3s.mp4','manuel_id'=>'405'],
           ////2sc/////
           ['titre' => 'Espace vectoriel','video'=>'/video/2s.mp4','manuel_id'=>'419'],
           ['titre' => 'Continuité et limite','video'=>'/video/3s.mp4','manuel_id'=>'419'],
           ['titre' => 'Dérivé et Primitive','video'=>'/video/4m.mp4','manuel_id'=>'419'],
           //3sc///
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/3s.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'1'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/4m.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'1'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/p1.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'1'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/p1.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'2'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/2s.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'2'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/4m.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'2'],
           ['titre' => 'Chapitre1:Généralité sur les fonctions:Activité','video'=>'/video/3s.mp4','manuel_id'=>'472','page'=>'6','description'=>'activité','numero'=>'2'],

           //4math///
           ['titre' => 'Espace vectoriel','video'=>'/video/4m.mp4','manuel_id'=>'552'],
           ['titre' => 'Dérivé et Primitive','video'=>'/video/3s.mp4','manuel_id'=>'552'],
           ['titre' => 'Continuité et limite','video'=>'/video/p1.mp4','manuel_id'=>'552'],
        ];
        foreach ($video as $key => $value) {

           video::create($value);
      
          }
    }
}
