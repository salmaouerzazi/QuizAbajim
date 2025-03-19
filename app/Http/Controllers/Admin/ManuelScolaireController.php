<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manuels;
use App\Models\Material;
use App\Models\School_level;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManuelScolaireController extends Controller
{
    public function index(Request $request)
    {
        $query = Manuels::with([
            'videos' => function ($q) {
                $q->select('manuel_id', 'page', 'numero', 'user_id')->distinct();
            },
            'matiere',
            'matiere.section',
            'matiere.section.level',
        ]);

        $level_id = $request->get('level_id');
        $matiere_name = $request->get('matiere_name');
        $teacher_ids = $request->get('teacher_ids');

        if (!empty($level_id)) {
            $query->whereHas('matiere.section.level', function ($q) use ($level_id) {
                $q->where('id', $level_id);
            });
        }

        if (!empty($matiere_name)) {
            $query->whereHas('matiere', function ($q) use ($matiere_name) {
                $q->where('name', $matiere_name);
            });
        }

        if (!empty($teacher_ids) && count($teacher_ids)) {
            $query->whereHas('videos', function ($q) use ($teacher_ids) {
                $q->whereIn('user_id', $teacher_ids);
            });
        }

        $sort = $request->get('sort');
        if (!empty($sort)) {
            switch ($sort) {
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'updated_at_asc':
                    $query->orderBy('updated_at', 'asc');
                    break;
                case 'updated_at_desc':
                    $query->orderBy('updated_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $manuels = $query->paginate(10);

        $level = School_level::all();
        $matieres = Material::get()->unique('name');

        $teachers = User::whereIn('id', $manuels->pluck('videos.*.user_id')->flatten()->unique())->get();

        return view('admin.manuel_scolaire.index', [
            'pageTitle' => 'admin/main.additional_pages_title',
            'manuels' => $manuels,
            'level' => $level,
            'matieres' => $matieres,
            'teachers' => $teachers,
        ]);
    }
}
