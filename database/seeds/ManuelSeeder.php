<?php

use Illuminate\Database\Seeder;
use App\Models\Manuels;
class ManuelSeeder extends Seeder
{


        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            
            $manuels = [
               ///1////
               
              ['name' => 'Sciences SVT','logo'=>'/1 ere/svt.jpeg','material_id'=>'1'],
              ['name' => 'Mathématiques','logo'=>'/1 ere/math1.jpeg','material_id'=>'2'],
              ['name' => 'Physiques','logo'=>'/1 ere/physique1.jpg','material_id'=>'3'],
              ['name' => 'Chimie','logo'=>'/1 ere/chimie.jpg','material_id'=>'4'],
              ['name' => 'Informatique','logo'=>'/1 ere/informatique1.jpg','material_id'=>'5'],
              ['name' => 'Technologie','logo'=>'/1 ere/tech1.jpeg','material_id'=>'6'],
              ['name' => 'Technologie','logo'=>'/1 ere/tech2.jpeg','material_id'=>'6'],
              ['name' => 'Arabe','logo'=>'/1 ere/arabe1.jpg','material_id'=>'7'],
              ['name' => 'Pensée Islamique','logo'=>'/1 ere/islam1.jpg','material_id'=>'8'],
              ['name' => 'Education civile','logo'=>'/1 ere/madani1.jpg','material_id'=>'9'],
              ['name' => 'Histoire','logo'=>'/1 ere/tarikh1.jpg','material_id'=>'10'],
              ['name' => 'Géographie','logo'=>'/1 ere/geographie1.jpg','material_id'=>'11'],
              ['name' => 'Francais','logo'=>'/1 ere/franc1.jpg','material_id'=>'12'],
              ['name' => 'Anglais','logo'=>'/1 ere/english.jpeg','material_id'=>'13'],
    
              
    
              //2science///
              ['name' => 'Sciences SVT','logo'=>'/2 eme scien/svt2.jpeg','material_id'=>'368'],
              ['name' => 'Mathématiques','logo'=>'/2 eme scien/math21.jpeg','material_id'=>'369'],
              ['name' => 'Mathématiques','logo'=>'/2 eme scien/math22.jpeg','material_id'=>'369'],
              ['name' => 'Physiques','logo'=>'/2 eme scien/phys2.jpeg','material_id'=>'370'],
              ['name' => 'chimie','logo'=>'/2 eme scien/chimie2.jpeg','material_id'=>'371'],
              ['name' => 'Informatique','logo'=>'/2 eme scien/infor.jpeg','material_id'=>'372'],
              ['name' => 'Technologie','logo'=>'/2 eme scien/tech cours 2.jpeg','material_id'=>'373'],
              ['name' => 'Arabe','logo'=>'/2 eme scien/arabe2.jpg','material_id'=>'374'],
              ['name' => 'Arabe','logo'=>'/2 eme scien/arabe22.jpg','material_id'=>'374'],
              ['name' => 'Pensée Islamique','logo'=>'/2 eme scien/islam2.jpg','material_id'=>'375'],
              ['name' => 'Education civile','logo'=>'/2 eme scien/madani2.jpg','material_id'=>'376'],
              ['name' => 'Histoire','logo'=>'/2 eme scien/histoire2.jpg','material_id'=>'377'],
              ['name' => 'Géographie','logo'=>'/2 eme scien/geo2.jpg','material_id'=>'378'],
              ['name' => 'Francais','logo'=>'/2 eme scien/fr2.jpeg','material_id'=>'379'],
              ['name' => 'Anglais','logo'=>'/2 eme scien/english2.jpeg','material_id'=>'380'],
    
    
    
    
              ///2 informatique///
            ['name' => 'Informatique','logo'=>'/2 eme info/info2.jpg','material_id'=>'392'],
            ['name' => 'Mathématiques','logo'=>'/2 eme info/math.jpeg','material_id'=>'393'],
            ['name' => 'Mathématiques','logo'=>'/2 eme info/math 12.jpg','material_id'=>'393'],
            ['name' => 'Physiques','logo'=>'/2 eme info/phys2.jpg','material_id'=>'394'],
            ['name' => 'Chimie','logo'=>'/2 eme info/chimie2.jpg','material_id'=>'395'],
            ['name' => 'Arabe','logo'=>'/2 eme info/arabe2.jpg','material_id'=>'396'],
            ['name' => 'Arabe','logo'=>'/2 eme info/arabe22.jpg','material_id'=>'396'],
            ['name' => 'Francais','logo'=>'/2 eme info/fran2.jpg','material_id'=>'397'],
            ['name' => 'Anglais','logo'=>'/2 eme info/engl2.jpg','material_id'=>'398'],
            ['name' => 'Technologie','logo'=>'/2 eme info/tech2.jpg','material_id'=>'399'],
            ['name' => 'Pensée Islamique','logo'=>'/2 eme info/islam2.jpg','material_id'=>'400'],
            ['name' => 'Education civile','logo'=>'/2 eme  info/madania2.jpg','material_id'=>'401'],
            ['name' => 'Histoire','logo'=>'/2 eme  info/histoire2.jpg','material_id'=>'402'],
            ['name' => 'Géographie','logo'=>'/2 eme  info/geo2.jpg','material_id'=>'403'],
    
           ///2 lettre///
    
            ['name' => 'Philosofie','logo'=>'/2 eme lettre/philo.jpg','material_id'=>'381'],
            ['name' => 'Arabe','logo'=>'/2 eme lettre/arabe2.jpg','material_id'=>'382'],
            ['name' => 'Arabe','logo'=>'/2 eme lettre/arabe22.jpg','material_id'=>'382'],
            ['name' => 'Pensée Islamique','logo'=>'/2 eme lettre/islam.jpeg','material_id'=>'383'],
            ['name' => 'Education civile','logo'=>'/2 eme lettre/madania.jpeg','material_id'=>'384'],
            ['name' => 'Histoire','logo'=>'/2 eme lettre/histoire.jpeg','material_id'=>'385'],
            ['name' => 'Géographie','logo'=>'/2 eme lettre/geo.jpeg','material_id'=>'386'],
            ['name' => 'Francais','logo'=>'/2 eme lettre/fra.jpeg','material_id'=>'387'],
            ['name' => 'Anglais','logo'=>'/2 eme lettre/eng.jpg','material_id'=>'388'],
            ['name' => 'Informatique','logo'=>'/2 eme lettre/info.jpeg','material_id'=>'389'],
            ['name' => 'Mathématiques','logo'=>'/2 eme lettre/math.jpg','material_id'=>'390'],
            ['name' => 'Siences SVT','logo'=>'/2 eme lettre/svt.jpg','material_id'=>'391'],
    
     
            ///2 Economie////
     
            ['name' => 'Economie','logo'=>'/2 eme eco/eco.jpeg','material_id'=>'404'],
            ['name' => 'Gestion','logo'=>'/2 eme eco/gestion.jpeg','material_id'=>'405'],
            ['name' => 'Informatique','logo'=>'/2 eme eco/info.jpeg','material_id'=>'406'],
            ['name' => 'Mathématiques','logo'=>'/2 eme eco/math.jpeg','material_id'=>'407'],
            ['name' => 'Arabe','logo'=>'/2 eme eco/arabe2.jpg','material_id'=>'408'],
            ['name' => 'Arabe','logo'=>'/2 eme eco/arabe22.jpg','material_id'=>'408'],
            ['name' => 'Francais','logo'=>'/2 eme eco/fra.jpeg','material_id'=>'409'],
            ['name' => 'Anglais','logo'=>'/2 eme eco/engl.jpg','material_id'=>'410'],
            ['name' => 'Pensée Islamique','logo'=>'/2 eme eco/islam.jpeg','material_id'=>'411'],
            ['name' => 'Education civile','logo'=>'/2 eme eco/madania.jpeg','material_id'=>'412'],
            ['name' => 'Histoire','logo'=>'/2 eme eco/histoire.jpeg','material_id'=>'413'],
            ['name' => 'Géographie','logo'=>'/2 eme eco/geo.jpeg','material_id'=>'414'],
    
    
             ///3 science//
            ['name' => 'Sciences SVT','logo'=>'/3 eme science/svt.jpeg','material_id'=>'415'],
            ['name' => 'Mathématiques','logo'=>'/3 eme science/math1.jpeg','material_id'=>'416'],
            ['name' => 'Mathématiques','logo'=>'/3 eme science/math2.jpeg','material_id'=>'416'],
            ['name' => 'Physiques','logo'=>'/3 eme science/phy.jpeg','material_id'=>'417'],
            ['name' => 'Chimie','logo'=>'/3 eme science/chimie.jpg','material_id'=>'418'],
            ['name' => 'Informatique','logo'=>'/3 eme science/infor.jpeg','material_id'=>'419'],
            ['name' => 'Arabe','logo'=>'/3 eme science/arabe.jpg','material_id'=>'420'],
            ['name' => 'Histoire','logo'=>'/3 eme science/histoire.jpg','material_id'=>'421'],
            ['name' => 'Géographie','logo'=>'/3 eme science/geo.jpg','material_id'=>'422'],
            ['name' => 'Francais','logo'=>'/3 eme science/fran.jpeg','material_id'=>'423'],
            ['name' => 'Anglais','logo'=>'/3 eme science/engli.jpeg','material_id'=>'424'],
            ['name' => 'Philosofie','logo'=>'/3 eme science/philoso.jpg','material_id'=>'425'],
    
             //3 math//
            ['name' => 'Sciences SVT','logo'=>'/3 eme science/svt.jpeg','material_id'=>'426'],
            ['name' => 'Mathématiques','logo'=>'/3 eme math/math1.jpeg','material_id'=>'427'],
            ['name' => 'Mathématiques','logo'=>'/3 eme math/math2.jpeg','material_id'=>'427'],
            ['name' => 'Physiques','logo'=>'/3 eme math/physique.jpeg','material_id'=>'428'],
            ['name' => 'Chimie','logo'=>'/3 eme math/chimie.jpeg','material_id'=>'429'],
            ['name' => 'Informatique','logo'=>'/3 eme math/infor.jpeg','material_id'=>'430'],
            ['name' => 'Arabe','logo'=>'/3 eme math/arabe.jpg','material_id'=>'431'],
            ['name' => 'Histoire','logo'=>'/3 eme math/histoire.jpg','material_id'=>'432'],
            ['name' => 'Géographie','logo'=>'/3 eme math/geo.jpg','material_id'=>'433'],
            ['name' => 'Francais','logo'=>'/3 eme math/fran.jpeg','material_id'=>'434'],
            ['name' => 'Anglais','logo'=>'/3 eme math/engli.jpeg','material_id'=>'435'],
            ['name' => 'Philosofie','logo'=>'/3 eme math/philos.jpg','material_id'=>'436'],
    
             //3 tech//
          ['name' => 'Elèctrique','logo'=>'/3 eme tech/elec.jpeg','material_id'=>'437'],
          ['name' => 'Elèctrique','logo'=>'/3 eme tech/elec2.jpg','material_id'=>'437'],
          ['name' => 'Mécanique','logo'=>'/3 eme tech/meca.jpeg','material_id'=>'438'],
          ['name' => 'Mécanique','logo'=>'/3 eme tech/meca2.jpeg','material_id'=>'438'],
          ['name' => 'Mathématiques','logo'=>'/3 eme tech/math.jpeg','material_id'=>'439'],
          ['name' => 'Physiques','logo'=>'/3 eme tech/phys.jpeg','material_id'=>'440'],
          ['name' => 'Chimie','logo'=>'/3 eme tech/chimie.jpeg','material_id'=>'441'],
          ['name' => 'Informatique','logo'=>'/3 eme tech/infor.jpeg','material_id'=>'442'],
          ['name' => 'Arabe','logo'=>'/3 eme tech/arabe.jpg','material_id'=>'443'],
          ['name' => 'Histoire','logo'=>'/3 eme tech/histoire.jpg','material_id'=>'444'],
          ['name' => 'Géographie','logo'=>'/3 eme tech/geo.jpg','material_id'=>'445'],
          ['name' => 'Francais','logo'=>'/3 eme tech/fran.jpeg','material_id'=>'446'],
          ['name' => 'Anglais','logo'=>'/3 eme tech/engli.jpeg','material_id'=>'447'],
          ['name' => 'Philosofie','logo'=>'/3 eme tech/philos.jpg','material_id'=>'448'],
    
      // ///3 informatique////
      ['name' => 'Algorithme Et Programmation','logo'=>'/3 eme info/prog.jpeg','material_id'=>'449'],
      ['name' => 'Système D"exploitation','logo'=>'/3 eme info/exploi.jpeg','material_id'=>'450'],
      ['name' => 'Mathématiques','logo'=>'/3 eme info/math.jpeg','material_id'=>'451'],
      ['name' => 'Physiques','logo'=>'/3 eme info/phy.jpeg','material_id'=>'452'],
      ['name' => 'Chimie','logo'=>'/3 eme info/chimie.jpg','material_id'=>'453'],
      ['name' => 'Arabe','logo'=>'/3 eme info/arabe.jpg','material_id'=>'454'],
      ['name' => 'Histoire','logo'=>'/3 eme info/histoire.jpg','material_id'=>'455'],
      ['name' => 'Géographie','logo'=>'/3 eme info/geo.jpg','material_id'=>'456'],
      ['name' => 'Francais','logo'=>'/3 eme info/fran.jpeg','material_id'=>'457'],
      ['name' => 'Anglais','logo'=>'/3 eme info/engli.jpeg','material_id'=>'458'],
      ['name' => 'Tic','logo'=>'/3 eme info/tic.jpg','material_id'=>'459'],
      ['name' => 'Philosofie','logo'=>'/3 eme info/philo.jpg','material_id'=>'460'],
      
        //3lettre///
    
        ['name' => 'Philosofie','logo'=>'/3 eme lettre/philo.jpg','material_id'=>'461'],
        ['name' => 'Arabe','logo'=>'/3 eme lettre/arabe.jpg','material_id'=>'462'],
        ['name' => 'Pensée Islamique','logo'=>'/3 eme lettre/islam.jpg','material_id'=>'463'],
        ['name' => 'Education civile','logo'=>'/3 eme lettre/madania.jpg','material_id'=>'464'],
        ['name' => 'Histoire','logo'=>'/3 eme lettre/histoire.jpg','material_id'=>'465'],
        ['name' => 'Géographie','logo'=>'/3 eme lettre/geo.jpeg','material_id'=>'466'],
        ['name' => 'Francais','logo'=>'/3 eme lettre/frans.jpeg','material_id'=>'467'],
        ['name' => 'Anglais','logo'=>'/3 eme lettre/engl.jpeg','material_id'=>'468'],
        ['name' => 'Informatique','logo'=>'/3 eme lettre/infor.jpeg','material_id'=>'469'],
        ['name' => 'Mathématiques','logo'=>'/3 eme lettre/math.jpeg','material_id'=>'470'],
    
      //3 Economie///
      ['name' => 'Economie','logo'=>'/3 eme eco/eco.jpg','material_id'=>'471'],
      ['name' => 'Gestion','logo'=>'/3 eme eco/gest.jpg','material_id'=>'472'],
      ['name' => 'Informatique','logo'=>'/3 eme eco/info.jpg','material_id'=>'473'],
      ['name' => 'Mathématiques','logo'=>'/3 eme eco/math.jpg','material_id'=>'474'],
      ['name' => 'Arabe','logo'=>'/3 eme eco/arabe.jpg','material_id'=>'475'],
      ['name' => 'Francais','logo'=>'/3 eme eco/fran.jpg','material_id'=>'476'],
      ['name' => 'Anglais','logo'=>'/3 eme eco/engl.jpeg','material_id'=>'477'],
      ['name' => 'Histoire','logo'=>'/3 eme eco/hist.jpg','material_id'=>'478'],
      ['name' => 'Géographie','logo'=>'/3 eme eco/geo.jpeg','material_id'=>'479'],
      ['name' => 'Philosofie','logo'=>'/3 eme eco/philo.jpg','material_id'=>'480'],
     
    
      ///bac science///
      ['name' => 'Sciences SVT','logo'=>'/bac science/svt.jpg','material_id'=>'481'],
        ['name' => 'Mathématiques','logo'=>'/bac science/math1.jpg','material_id'=>'482'],
        ['name' => 'Mathématiques','logo'=>'/bac science/math2.jpg','material_id'=>'482'],
        ['name' => 'Physiques','logo'=>'/bac science/physique.jpg','material_id'=>'483'],
        ['name' => 'Chimie','logo'=>'/bac science/chimie.jpg','material_id'=>'484'],
        ['name' => 'Informatique','logo'=>'/bac science/info.jpg','material_id'=>'485'],
        ['name' => 'Arabe','logo'=>'/bac science/arabe.jpg','material_id'=>'486'],
        ['name' => 'Francais','logo'=>'/bac science/fran.jpg','material_id'=>'487'],
        ['name' => 'Anglais','logo'=>'/bac science/eng.jpg','material_id'=>'488'],
        ['name' => 'Philosofie','logo'=>'/bac science/philo.jpg','material_id'=>'489'],
       
        //bac math//
        ['name' => 'Sciences SVT','logo'=>'/bac math/svt.jpeg','material_id'=>'490'],
        ['name' => 'Mathématiques','logo'=>'/bac math/math1.jpg','material_id'=>'491'],
        ['name' => 'Mathématiques','logo'=>'/bac math/math2.jpg','material_id'=>'491'],
        ['name' => 'Physiques','logo'=>'/bac math/physique.jpg','material_id'=>'492'],
        ['name' => 'Chimie','logo'=>'/bac math/chimie.jpg','material_id'=>'493'],
        ['name' => 'Informatique','logo'=>'/bac math/info.jpg','material_id'=>'494'],
        ['name' => 'Arabe','logo'=>'/bac math/arabe.jpg','material_id'=>'495'],
        ['name' => 'Francais','logo'=>'/bac math/fran.jpg','material_id'=>'496'],
        ['name' => 'Anglais','logo'=>'/bac math/eng.jpg','material_id'=>'497'],
        ['name' => 'Philosofie','logo'=>'/bac math/philo.jpg','material_id'=>'498'],
            
      //bac technique///
      ['name' => 'Elèctrique','logo'=>'/bac technique/elect.jpg','material_id'=>'499'],
      ['name' => 'Elèctrique','logo'=>'/bac technique/elect 2.jpg','material_id'=>'499'],
      ['name' => 'Mécanique','logo'=>'/bac technique/meca.jpg','material_id'=>'500'],
      ['name' => 'Mécanique','logo'=>'/bac technique/meca2.jpg','material_id'=>'500'],
      ['name' => 'Mathématiques','logo'=>'/bac technique/math.jpg','material_id'=>'501'],
      ['name' => 'Physiques','logo'=>'/bac technique/phys.jpg','material_id'=>'502'],
      ['name' => 'Chimie','logo'=>'/bac technique/chimie.jpg','material_id'=>'503'],
      ['name' => 'Informatique','logo'=>'/bac technique/info.jpg','material_id'=>'504'],
      ['name' => 'Arabe','logo'=>'/bac technique/arabe.jpg','material_id'=>'505'],
      ['name' => 'Francais','logo'=>'/bac technique/fran.jpg','material_id'=>'506'],
      ['name' => 'Anglais','logo'=>'/bac technique/eng.jpg','material_id'=>'507'],
      ['name' => 'Philosofie','logo'=>'/bac technique/philo.jpg','material_id'=>'508'],
      
    
    
    
      ///bac informatique////
    ['name' => 'Algorithme Et Programmation','logo'=>'/bac info/algo.jpg','material_id'=>'509'],
    ['name' => 'Bases de données','logo'=>'/bac info/base.jpg','material_id'=>'510'],
    ['name' => 'Mathématiques','logo'=>'/bac info/math.jpg','material_id'=>'511'],
    ['name' => 'Physiques','logo'=>'/bac info/physique.jpg','material_id'=>'512'],
    ['name' => 'Chimie','logo'=>'/bac info/chimie.jpg','material_id'=>'513'],
    ['name' => 'Arabe','logo'=>'/bac info/arabe.jpg','material_id'=>'514'],
    ['name' => 'Francais','logo'=>'/bac info/fran.jpg','material_id'=>'515'],
    ['name' => 'Anglais','logo'=>'/bac info/eng.jpg','material_id'=>'516'],
    ['name' => 'Tic','logo'=>'/bac info/tic.jpg','material_id'=>'517'],
    ['name' => 'Philosofie','logo'=>'/bac info/philo.jpg','material_id'=>'518'],
    
      //bac lettre///
    
      ['name' => 'Philosofie','logo'=>'/bac lettre/philo.jpg','material_id'=>'519'],
      ['name' => 'Philosofie','logo'=>'/bac lettre/philo2.jpg','material_id'=>'519'],
      ['name' => 'Arabe','logo'=>'/bac lettre/arabe.jpg','material_id'=>'520'],
      ['name' => 'Pensée Islamique','logo'=>'/bac lettre/islam.jpg','material_id'=>'521'],
      ['name' => 'Histoire','logo'=>'/bac lettre/hist.jpg','material_id'=>'522'],
      ['name' => 'Géographie','logo'=>'/bac lettre/geo.jpg','material_id'=>'523'],
      ['name' => 'Francais','logo'=>'/bac lettre/fr.jpg','material_id'=>'524'],
      ['name' => 'Anglais','logo'=>'/bac lettre/eng.jpg','material_id'=>'525'],
      ['name' => 'Informatique','logo'=>'/bac lettre/inform.jpeg','material_id'=>'526'],
     
    
    //bac Economie///
    ['name' => 'Economie','logo'=>'/bac eco/eco.jpeg','material_id'=>'527'],
    ['name' => 'Gestion','logo'=>'/bac eco/gestion.jpg','material_id'=>'528'],
    ['name' => 'Informatique','logo'=>'/bac eco/info.jpg','material_id'=>'529'],
    ['name' => 'Mathématiques','logo'=>'/bac eco/math.jpg','material_id'=>'530'],
    ['name' => 'Arabe','logo'=>'/bac eco/arabe.jpg','material_id'=>'531'],
    ['name' => 'Francais','logo'=>'/bac eco/fran.jpg','material_id'=>'532'],
    ['name' => 'Anglais','logo'=>'/bac eco/eng.jpg','material_id'=>'533'],
    ['name' => 'Histoire','logo'=>'/bac eco/hist.jpg','material_id'=>'534'],
    ['name' => 'Géographie','logo'=>'/bac eco/geo.jpg','material_id'=>'535'],
    ['name' => 'Philosofie','logo'=>'/bac eco/phio.jpg','material_id'=>'536'],
    
    ///option////
    
    ['name' => 'Italien','logo'=>'/bac eco/eco.jpeg','material_id'=>'527'],
    ['name' => 'Allemand','logo'=>'/bac eco/gestion.jpg','material_id'=>'528'],
    ['name' => 'Ispagnol','logo'=>'/bac eco/info.jpg','material_id'=>'529'],
    ['name' => 'Mathématiques','logo'=>'/bac eco/math.jpg','material_id'=>'530'],
    ['name' => 'Arabe','logo'=>'/bac eco/arabe.jpg','material_id'=>'531'],
    ['name' => 'Francais','logo'=>'/bac eco/fran.jpg','material_id'=>'532'],
      
      
      
      
      
      
      ];
    
            foreach ($manuels as $key => $value) {
    
              manuels::create($value);
        
            }
        }

    
}
