<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmaterialSeeder extends Seeder
{
    public function run()
    {
        $arabicMaterials = DB::table('materials')->where('name', 'العربية')->get();

        $submaterialNames = [
            'الانتاج الكتابي',
            'القراءة',
            'قواعد اللغة',
            'كتابة',
            'تواصل شفوي',
        ];

        $submaterials = [];

        foreach ($arabicMaterials as $material) {
            foreach ($submaterialNames as $name) {
                $submaterials[] = [
                    'material_id' => $material->id,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('submaterials')->insert($submaterials);
    }
}
