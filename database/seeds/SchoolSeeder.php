<?php

use Illuminate\Database\Seeder;
use App\Models\School;
class SchoolSeeder extends Seeder
{
 /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
         
            /*School::truncate();*/
     
      
    
            $school = [
    
                ['name' => 'École primaire El Menzah 8','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Molière','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Ariana Sup','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Riadh Enassr','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Enassr1 ','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Les pyramides','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire Riadh Andalous','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire René Descartes','type'=>'Primaire','city'=>'Ariana'],
                ['name' => 'École primaire El Ferdaws','type'=>'Primaire','city'=>'Ariana'],
               
               
                ['name' => 'Lycée Mnihla','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Mahmoud Elmassadi Cité Tadhamon','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Rafeha Mnihla','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Eljadid Cité Tadhamon','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Abou Kacem Chebbi Cité Tadhamon','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Hassen Hosni Abd Elwaheb Mnihla','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Bayrem 5 El Manzeh 8','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Enassr','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Attarine','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Hannabal','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée khayer Edine','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Raoued','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Sidi Thabet','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Elghazala Raoued ','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Elwafa','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Borj Elwazir Sokra','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Sokra','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Dar Fadhal Sokra ','type'=>'Secondaire','city'=>'Ariana'],
                ['name' => 'Lycée Kalaat El Andalous','type'=>'Secondaire','city'=>'Ariana'],
                
                ['name' => 'École supérieure privée d ingénieries et de technologies' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Institut supérieur d informatique' ,'type'=>'Université','city'=>'Ariana'],
                 ['name' => 'Time Université' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Université Ibn Khaldoun' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Université de sésame' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Université tunis carthage' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Ecole nationale de médecine de vétérinaire de Sidi Thabet' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'École supérieure de communication de Tunis' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Institut national du travail et des études sociales' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Institut national de recherches en génie rural,eaux et forets INRGREF' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Institut national de la recherche en agronomique de Tunisie' ,'type'=>'Université','city'=>'Ariana'],
                ['name' => 'Institut supérieur des études préparatoires en biologie géologie ','type'=>'Université','city'=>'Ariana'],
                ['name' => 'École supérieure privée technologie et ingénierie' ,'type'=>'Université','city'=>'Ariana'],
                
                ['name' => 'Lycée Mejez El Bab','type'=>'Secondaire','city'=>'Béja'],
                ['name' => 'Lycée Testour','type'=>'Secondaire','city'=>'Béja'],
                ['name' => 'Lycée Ibn Zaydoun Testour','type'=>'Secondaire','city'=>'Béja'],
                ['name' => 'Lycée Béja Nord','type'=>'Secondaire','city'=>'Béja'],
                ['name' => 'Lycée 2 Mars 1938 Goubellate','type'=>'Secondaire','city'=>'Béja'],
                
                 
                ['name' => 'Lycée Boukornine','type'=>'Secondaire','city'=>'Ben Arous'],
                ['name' => 'Lycée El Moutanabi','type'=>'Secondaire','city'=>'Ben Arous'],
                ['name' => 'Lycée El Menhel','type'=>'Secondaire','city'=>'Ben Arous'],
                ['name' => 'Lycée Ibn Arafa','type'=>'Secondaire','city'=>'Ben Arous'],
                ['name' => 'Lycée La jaconde','type'=>'Secondaire','city'=>'Ben Arous'],
                
                 ['name' => 'Lycée L avenir','type'=>'Secondaire','city'=>'Bizerte'],
                 ['name' => 'Lycée La sagesse','type'=>'Secondaire','city'=>'Bizerte'],
                 ['name' => 'Lycée Outik','type'=>'Secondaire','city'=>'Bizerte'],
                 ['name' => 'Lycée Aliya','type'=>'Secondaire','city'=>'Bizerte'],
                
                 ['name' => 'Lycée Ibn-Sina','type'=>'Secondaire','city'=>'Gabès'],
                 ['name' => 'Lycée Manzel Habib','type'=>'Secondaire','city'=>'Gabès'],
                 ['name' => 'Lycée Arkoub Mareth','type'=>'Secondaire','city'=>'Gabès'],
                 ['name' => 'Lycée Mareth','type'=>'Secondaire','city'=>'Gabès'],
    
                 ['name' => 'Lycée Sidi Boubaker','type'=>'Secondaire','city'=>'Gafsa'],
                 ['name' => 'Lycée Alim Gafsa','type'=>'Secondaire','city'=>'Gafsa'],
                 ['name' => 'Lycée Koussa Snad','type'=>'Secondaire','city'=>'Gafsa'],
                 ['name' => 'Lycée Mdhila','type'=>'Secondaire','city'=>'Gafsa'],
    
                 ['name' => 'Lycée Ghar Dimaa','type'=>'Secondaire','city'=>'Jendouba'],
                 ['name' => 'Lycée Ibn Khaldoune Fournena','type'=>'Secondaire','city'=>'Jendouba'],
                 ['name' => 'Lycée Wedi Mliz','type'=>'Secondaire','city'=>'Jendouba'],
                 ['name' => 'Lycée Tamouh Ghar Dimaa','type'=>'Secondaire','city'=>'Jendouba'],
    
                 ['name' => 'Lycée El Houriya','type'=>'Secondaire','city'=>'Kairouan'],
                 ['name' => 'Lycée El Afak','type'=>'Secondaire','city'=>'Kairouan'],
                 ['name' => 'Lycée El Farabi','type'=>'Secondaire','city'=>'Kairouan'],
                 ['name' => 'Lycée l avenir','type'=>'Secondaire','city'=>'Kairouan'],
                 ['name' => 'Lycée El Najah','type'=>'Secondaire','city'=>'Kairouan'],
    
                 ['name' => 'Lycée Abou Kacem Chebbi Feryana','type'=>'Secondaire','city'=>'Kasserine'],
                 ['name' => 'Lycée Monji Slim Sbiba','type'=>'Secondaire','city'=>'Kasserine'],
                 ['name' => 'Lycée Farhat hached Rakhamet','type'=>'Secondaire','city'=>'Kasserine'],
                 ['name' => 'Lycée Majel Abess','type'=>'Secondaire','city'=>'Kasserine'],
    
                 ['name' => 'Lycée Ibn Khaldoun','type'=>'Secondaire','city'=>'Kbeli'],
                 ['name' => 'Lycée Ibn Sina','type'=>'Secondaire','city'=>'Kbeli'],
    
                 ['name' => 'Lycée Monji Slin ELKèf','type'=>'Secondaire','city'=>'Kèf'],
                 ['name' => 'Lycée 2 Mares 1938','type'=>'Secondaire','city'=>'Kèf'],
                 ['name' => 'Lycée Ibn Jazar Naber','type'=>'Secondaire','city'=>'Kèf'],
                 ['name' => 'Lycée Ahmed Amara','type'=>'Secondaire','city'=>'Kèf'],
                 
    
                 ['name' => 'Lycée Alyssa','type'=>'Secondaire','city'=>'Mahdia'],
                 ['name' => 'Lycée El Horria','type'=>'Secondaire','city'=>'Mahdia'],
                 ['name' => 'Lycée Ibn Charaf','type'=>'Secondaire','city'=>'Mahdia'],
                 ['name' => 'Lycée Ouled Chamekh','type'=>'Secondaire','city'=>'Mahdia'],
                 ['name' => 'Lycée Sidi Alouane','type'=>'Secondaire','city'=>'Mahdia'],
    
    
                 ['name' => 'Lycée Ibn Roched','type'=>'Secondaire','city'=>'Manouba'],
                 ['name' => 'Lycée Oued Elil','type'=>'Secondaire','city'=>'Manouba'],
                 ['name' => 'Lycée Tahar Haded','type'=>'Secondaire','city'=>'Manouba'],
              
    
                 ['name' => 'Lycée May Jerba ','type'=>'Secondaire','city'=>'Mednine'],
                 ['name' => 'Lycée Kalela Ajim ','type'=>'Secondaire','city'=>'Mednine'],
                 ['name' => 'Lycée Ajim Jerba ','type'=>'Secondaire','city'=>'Mednine'],
    
                 ['name' => 'Lycée El Imtiaz ','type'=>'Secondaire','city'=>'Monastir'],
                 ['name' => 'Lycée El Rouki ','type'=>'Secondaire','city'=>'Monastir'],
                 ['name' => 'Lycée Lamta ','type'=>'Secondaire','city'=>'Monastir'],
                 ['name' => 'Lycée Sayada ','type'=>'Secondaire','city'=>'Monastir'],
                 
                 ['name' => 'Lycée Beni Khiar','type'=>'Secondaire','city'=>'Nabeul'],
                 ['name' => 'Lycée Idéale','type'=>'Secondaire','city'=>'Nabeul'],
                 ['name' => 'Lycée Bouarkoub','type'=>'Secondaire','city'=>'Nabeul'],
    
                 ['name' => 'Lycée Andalus','type'=>'Secondaire','city'=>'Sfax'],   
                 ['name' => 'Lycée Akareb 2','type'=>'Secondaire','city'=>'Sfax'],
                 ['name' => 'Lycée El Ghraiba','type'=>'Secondaire','city'=>'Sfax'],
    
                 ['name' => 'Lycée Taher Haded Regueb ','type'=>'Secondaire','city'=>'Sidi Bouzid'],
                 ['name' => 'Lycée Regueb ','type'=>'Secondaire','city'=>'Sidi Bouzid'],
                 ['name' => 'Lycée Mazouna','type'=>'Secondaire','city'=>'Sidi Bouzid'],
    
                 ['name' => 'Lycée Kessra','type'=>'Secondaire','city'=>'Siliana'],
                 ['name' => 'Lycée Hay EL ones 1 Rouhia','type'=>'Secondaire','city'=>'Siliana'],
                 ['name' => 'Lycée Farhat Hached Makther','type'=>'Secondaire','city'=>'Siliana'],
    
                 ['name' => 'Lycée ElManhel ','type'=>'Secondaire','city'=>'Sousse'],
                 ['name' => 'Lycée Elite ','type'=>'Secondaire','city'=>'Sousse'],
                 ['name' => 'Lycée Ettaoufik ','type'=>'Secondaire','city'=>'Sousse'],
    
                 ['name' => 'Lycée Bir Lahmer ','type'=>'Secondaire','city'=>'Tataouine'],
                 ['name' => 'Lycée Smar','type'=>'Secondaire','city'=>'Tataouine'],
                 ['name' => 'Lycée Remada','type'=>'Secondaire','city'=>'Tataouine'],
                   
                 ['name' => 'Lycée Hemma Jrid ','type'=>'Secondaire','city'=>'Tozeur'],
                 ['name' => 'Lycée Tamaghza ','type'=>'Secondaire','city'=>'Tozeur'],
                 ['name' => 'Lycée Nefta ','type'=>'Secondaire','city'=>'Tozeur'],
    
                 ['name' => 'Lycée Aboou Kacem Chakki ','type'=>'Secondaire','city'=>'Tunis'],
                 ['name' => 'Lycée ElAfek','type'=>'Secondaire','city'=>'Tunis'],
                 ['name' => 'Lycée ElAmir ','type'=>'Secondaire','city'=>'Tunis'],
    
                 ['name' => 'Lycée Ibn Haithem Saouaf ','type'=>'Secondaire','city'=>'Zaghouan'],
                 ['name' => 'Lycée Ibn Charaf Ennadhour ','type'=>'Secondaire','city'=>'Zaghouan'],
                 ['name' => 'Lycée Ghazeli Ennadhour ','type'=>'Secondaire','city'=>'Zaghouan'],
            ];
            foreach ($school as $key => $value) {
    
                School::create($value);
    
            }
        }
    
    
}
