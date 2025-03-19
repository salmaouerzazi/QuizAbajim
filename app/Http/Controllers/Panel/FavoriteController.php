<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Material;
use App\Models\Manuels;
use App\Models\Option;

class favoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');          

        $matiere =[];
        if( !empty($user->section_id)){
        $matiere =Material::where('section_id', $user->section_id)->get();
        }
        $favorites = Favorite::where('user_id', $user->id)
            ->with(['webinar' => function ($query) {
                $query->with(['teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                }, 'category']);
            }])
            ->orderBy('created_at','desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('panel.favorites'),
            'favorites' => $favorites,
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,
            'optiontearcher' => $optiontearcher,

            'matieretearcher'  => $matieretearcher,
        ];

        return view(getTemplate() . '.panel.webinar.favorites', $data);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $favorite = favorite::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!empty($favorite)) {
            $favorite->delete();

            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([], 422);
    }
}
