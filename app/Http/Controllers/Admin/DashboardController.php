<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\traits\DashboardTrait;
use App\Http\Controllers\Controller;
use App\Models\FeatureWebinar;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Ticket;
use App\Models\Webinar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use App\Models\Card;
use App\Models\School_level;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use DashboardTrait;

    public function generateKeys(Request $request)
    {
        $type = $request->input('type');
        switch ($type) {
            case 'school':
                $prefix = config('constants.CARD_TYPES.school');
                break;
            case 'pos':
                $prefix = config('constants.CARD_TYPES.pos');
                break;
            default:
                $prefix = config('constants.CARD_TYPES.other');
                break;
        }
    
        $levelId = $request->input('level_id');
        $expiresIn = $request->input('expires_in', 9);
        $numberOfKeys = $request->input('number_of_keys');
        $uniqueKeys = [];
    
        try {
            // Fetch the last reference to initialize the counter
            $lastRef = Card::where('reference', 'like', $prefix . '%')
                ->orderBy('reference', 'desc')
                ->value('reference');
    
            if ($lastRef) {
                $currentNumber = (int) substr($lastRef, strlen($prefix));
            } else {
                $currentNumber = 0;
            }
    
            // Loop to generate keys
            while (count($uniqueKeys) < $numberOfKeys) {
                $key = $this->generateFormattedKey();
    
                if (!in_array($key, $uniqueKeys)) {
                    $uniqueKeys[] = $key;
    
                    // Increment the reference number
                    $currentNumber++;
                    $reference = $prefix . str_pad($currentNumber, 7, '0', STR_PAD_LEFT);
    
                    // Log the generated reference
                    Log::info('Generated reference: ' . $reference);
    
                    // Create the card
                    Card::create([
                        'card_key'    => str_replace(' ', '', $key),
                        'reference'   => $reference,
                        'status'      => 'active',
                        'level_id'    => $levelId,
                        'subscribe_id'=> $request->input('subscribe_id', 3),
                        'expires_in'  => $expiresIn,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
    
            // Fetch the latest cards for response
            $cards = Card::latest()->paginate(10);
            return response()->json($cards);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    private function generateReference($prefix)
    {
        // Fetch the last reference starting with the given prefix
        $lastRef = Card::where('reference', 'like', $prefix . '%')
            ->orderBy('reference', 'desc')
            ->value('reference');
    
        if ($lastRef) {
            // Extract the numeric part after the prefix
            $num = (int) substr($lastRef, strlen($prefix));
        } else {
            $num = 0; // Start from 0 if no references exist
        }
    
        // Increment the number
        $num++;
    
        // Generate the reference with zero-padded numeric part
        return $prefix . str_pad($num, 7, '0', STR_PAD_LEFT); // 7-digit padding
    }


    private function generateFormattedKey()
    {
        $number = str_pad(mt_rand(0, 99999999), 9, '0', STR_PAD_LEFT);
        return wordwrap($number, 3, ' ', true);
    }

    public function indexCard()
    {
        $authUser = auth()->check() ? auth()->user() : null;
        $keys = Card::orderBy('created_at', 'desc')->paginate(10);
        $schoolLevels = School_level::all();
        $subscribes = Subscribe::all();

        $data = [
            'pageTitle' => trans('admin/main.general_dashboard_title'),
            'keys'=>$keys,
            'dailySalesTypeStatistics' => $dailySalesTypeStatistics ?? null,
            'authUser' => $authUser,
            'schoolLevels' => $schoolLevels,
            'subscribes' => $subscribes,
            
        ];
        return view('admin.financial.cards.card', $data);
    }

    public function index()
    {
        $this->authorize('admin_general_dashboard_show');

        if (Gate::allows('admin_general_dashboard_daily_sales_statistics')) {
            $dailySalesTypeStatistics = $this->dailySalesTypeStatistics();
        }

        if (Gate::allows('admin_general_dashboard_income_statistics')) {
            $getIncomeStatistics = $this->getIncomeStatistics();
        }

        if (Gate::allows('admin_general_dashboard_total_sales_statistics')) {
            $getTotalSalesStatistics = $this->getTotalSalesStatistics();
        }

        if (Gate::allows('admin_general_dashboard_new_sales')) {
            $getNewSalesCount = $this->getNewSalesCount();
        }

        if (Gate::allows('admin_general_dashboard_new_comments')) {
            $getNewCommentsCount = $this->getNewCommentsCount();
        }

        if (Gate::allows('admin_general_dashboard_new_tickets')) {
            $getNewTicketsCount = $this->getNewTicketsCount();
        }

        if (Gate::allows('admin_general_dashboard_new_reviews')) {
            $getPendingReviewCount = $this->getPendingReviewCount();
        }

        if (Gate::allows('admin_general_dashboard_sales_statistics_chart')) {
            $getMonthAndYearSalesChart = $this->getMonthAndYearSalesChart('month_of_year');
            $getMonthAndYearSalesChartStatistics = $this->getMonthAndYearSalesChartStatistics();
        }

        if (Gate::allows('admin_general_dashboard_recent_comments')) {
            $recentComments = $this->getRecentComments();
        }

        if (Gate::allows('admin_general_dashboard_recent_tickets')) {
            $recentTickets = $this->getRecentTickets();
        }

        if (Gate::allows('admin_general_dashboard_recent_webinars')) {
            $recentWebinars = $this->getRecentWebinars();
        }

        if (Gate::allows('admin_general_dashboard_recent_courses')) {
            $recentCourses = $this->getRecentCourses();
        }

        if (Gate::allows('admin_general_dashboard_users_statistics_chart')) {
            $usersStatisticsChart = $this->usersStatisticsChart();
        }

        $data = [
            'pageTitle' => trans('admin/main.general_dashboard_title'),
            'dailySalesTypeStatistics' => $dailySalesTypeStatistics ?? null,
            'getIncomeStatistics' => $getIncomeStatistics ?? null,
            'getTotalSalesStatistics' => $getTotalSalesStatistics ?? null,
            'getNewSalesCount' => $getNewSalesCount ?? 0,
            'getNewCommentsCount' => $getNewCommentsCount ?? 0,
            'getNewTicketsCount' => $getNewTicketsCount ?? 0,
            'getPendingReviewCount' => $getPendingReviewCount ?? 0,
            'getMonthAndYearSalesChart' => $getMonthAndYearSalesChart ?? null,
            'getMonthAndYearSalesChartStatistics' => $getMonthAndYearSalesChartStatistics ?? null,
            'recentComments' => $recentComments ?? null,
            'recentTickets' => $recentTickets ?? null,
            'recentWebinars' => $recentWebinars ?? null,
            'recentCourses' => $recentCourses ?? null,
            'usersStatisticsChart' => $usersStatisticsChart ?? null,
        ];

        return view('admin.dashboard', $data);
    }

    public function marketing()
    {
        $this->authorize('admin_marketing_dashboard_show');

        $buyerIds = Sale::whereNull('refund_at')
            ->pluck('buyer_id')
            ->toArray();
        $teacherIdsHasClass = Webinar::where('status', Webinar::$active)
            ->pluck('teacher_id')
            ->toArray();
        $teacherIdsHasClass = array_merge(array_keys($teacherIdsHasClass), $teacherIdsHasClass);


        $usersWithoutPurchases = User::whereNotIn('id', array_unique($buyerIds))->count();
        $teachersWithoutClass = User::where('role_name', Role::$teacher)
            ->whereNotIn('id', array_unique($teacherIdsHasClass))
            ->count();
        $featuredClasses = FeatureWebinar::where('status', 'publish')
            ->count();

        $now = time();
        $activeDiscounts = Ticket::where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->count();

        $getClassesStatistics = $this->getClassesStatistics();

        $getNetProfitChart = $this->getNetProfitChart();

        $getNetProfitStatistics = $this->getNetProfitStatistics();

        $getTopSellingClasses = $this->getTopSellingClasses();

        $getTopSellingAppointments = $this->getTopSellingAppointments();

        $getTopSellingTeachers = $this->getTopSellingTeachersAndOrganizations('teachers');

        $getTopSellingOrganizations = $this->getTopSellingTeachersAndOrganizations('organizations');

        $getMostActiveStudents = $this->getMostActiveStudents();

        $data = [
            'pageTitle' => trans('admin/main.marketing_dashboard_title'),
            'usersWithoutPurchases' => $usersWithoutPurchases,
            'teachersWithoutClass' => $teachersWithoutClass,
            'featuredClasses' => $featuredClasses,
            'activeDiscounts' => $activeDiscounts,
            'getClassesStatistics' => $getClassesStatistics,
            'getNetProfitChart' => $getNetProfitChart,
            'getNetProfitStatistics' => $getNetProfitStatistics,
            'getTopSellingClasses' => $getTopSellingClasses,
            'getTopSellingAppointments' => $getTopSellingAppointments,
            'getTopSellingTeachers' => $getTopSellingTeachers,
            'getTopSellingOrganizations' => $getTopSellingOrganizations,
            'getMostActiveStudents' => $getMostActiveStudents,
        ];

        return view('admin.marketing_dashboard', $data);
    }

    public function getSaleStatisticsData(Request $request)
    {
        $this->authorize('admin_general_dashboard_sales_statistics_chart');

        $type = $request->get('type');

        $chart = $this->getMonthAndYearSalesChart($type);

        return response()->json([
            'code' => 200,
            'chart' => $chart
        ], 200);
    }

    public function getNetProfitChartAjax(Request $request)
    {

        $type = $request->get('type');

        $chart = $this->getNetProfitChart($type);

        return response()->json([
            'code' => 200,
            'chart' => $chart
        ], 200);
    }

    public function cacheClear()
    {
        $this->authorize('admin_clear_cache');

        Artisan::call('clear:all');

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => 'Website cache successfully cleared.',
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }
}
