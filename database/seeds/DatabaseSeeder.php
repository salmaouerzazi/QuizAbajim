<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(SectionsTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(PaymentChannelsTableSeeder::class);
        //  $this->call(DocumentSeeder::class);
        //1 $this->call(SectionSeeder::class);
        //1 $this->call(SchoolSeeder::class);
        // $this->call(VideoSeeder::class);
        //1 $this->call(ManuelSeeder::class);
        //1 $this->call(OptionSeeder::class);
        //1  $this->call(School_levelSeeder::class);
        
        $this->call(MaterialSeeder::class);
        $this->call(SubmaterialSeeder::class);
        
        
       
    }
}
