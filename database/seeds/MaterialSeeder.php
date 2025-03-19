<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            ['id' => 1, 'name' => 'العربية', 'material_image' => '/11el/1ére-arabe.png', 'section_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'رياضيات', 'material_image' => '/11el/1ére-math.png', 'section_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'رياضيات', 'material_image' => '/22el/2éme-math.png', 'section_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'العربية', 'material_image' => '/22el/2éme-arabe.png', 'section_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'العربية', 'material_image' => '/33el/3éme-arabe.png', 'section_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'الإيقاظ العلمي', 'material_image' => '/33el/3éme-sc.png', 'section_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'الفرنسية', 'material_image' => '/33el/3éme-francais.png', 'section_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'رياضيات', 'material_image' => '/33el/3éme-math.png', 'section_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'رياضيات', 'material_image' => '/44el/4éme-arabe.png', 'section_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'الإيقاظ العلمي', 'material_image' => '/44el/4éme-sc.png', 'section_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'الفرنسية', 'material_image' => '/44el/4éme - francais.png', 'section_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'العربية', 'material_image' => '/44el/4éme-arabe.png', 'section_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'الإيقاظ العلمي', 'material_image' => '/55el/سنة خامسة(1).png', 'section_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'الفرنسية', 'material_image' => '/55el/5éme-francais.png', 'section_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'المواد الاجتماعية', 'material_image' => '/55el/5éme-mawad.png', 'section_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'رياضيات', 'material_image' => '/55el/سنة خامسة(2).png', 'section_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'العربية', 'material_image' => '/55el/سنة خامسة.png', 'section_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'رياضيات', 'material_image' => '/66el/6éme-math.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'المواد الاجتماعية', 'material_image' => '/66el/6éme-mawad.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'الإنجليزية', 'material_image' => '/66el/6éme-english.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'الفرنسية', 'material_image' => '/66el/6éme-fr.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'العربية', 'material_image' => '/66el/6éme-arabe.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'الإيقاظ العلمي', 'material_image' => '/66el/6éme-sc.png', 'section_id' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
