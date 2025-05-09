<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Setting;
use App\Models\Subscribe;
use App\User;
use Illuminate\Http\Request;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Material;
use App\Models\Option;

class SubscribesController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $subscribes = Subscribe::all();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');          

        $matiere =[];
        if( !empty($user->section_id)){
        $matiere =Material::where('section_id', $user->section_id)->get();
        }
        $data = [
            'pageTitle' => trans('financial.subscribes'),
            'subscribes' => $subscribes,
            'activeSubscribe' => Subscribe::getActiveSubscribe($user->id),
            'dayOfUse' => Subscribe::getDayOfUse($user->id),
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,
            'matieretearcher'  => $matieretearcher,
            'optiontearcher' => $optiontearcher,

        ];

        return view(getTemplate() . '.panel.financial.subscribes', $data);
    }

    public function pay(Request $request)
    {
        $paymentChannels = PaymentChannel::where('status', 'active')->get();

        $subscribe = Subscribe::where('id', $request->input('id'))->first();

        if (empty($subscribe)) {
            $toastData = [
                'msg' => trans('site.subscribe_not_valid'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $user = auth()->user();
        $activeSubscribe = Subscribe::getActiveSubscribe($user->id);

        if ($activeSubscribe) {
            $toastData = [
                'title' => trans('public.request_failed'),
                'msg' => trans('site.you_have_active_subscribe'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $financialSettings = getFinancialSettings();
        $tax = $financialSettings['tax'] ?? 0;

        $amount = $subscribe->price;

        $taxPrice = $tax ? $amount *  $tax / 100 : 0;

        $order = Order::create([
            "user_id" => $user->id,
            "status" => Order::$pending,
            'tax' => $taxPrice,
            'commission' => 0,
            "amount" => $amount,
            "total_amount" => $amount + $taxPrice,
            "created_at" => time(),
        ]);

        OrderItem::updateOrCreate([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'subscribe_id' => $subscribe->id,
        ], [
            'amount' => $order->amount,
            'total_amount' => $amount + $taxPrice,
            'tax' => $tax,
            'tax_price' => $taxPrice,
            'commission' => 0,
            'commission_price' => 0,
            'created_at' => time(),
        ]);

        $razorpay = false;
        foreach ($paymentChannels as $paymentChannel) {
            if ($paymentChannel->class_name == 'Razorpay') {
                $razorpay = true;
            }
        }

        $data = [
            'pageTitle' => trans('public.checkout_page_title'),
            'paymentChannels' => $paymentChannels,
            'total' => $order->total_amount,
            'order' => $order,
            'count' => 1,
            'userCharge' => $user->getAccountingCharge(),
            'razorpay' => $razorpay
        ];

        return view(getTemplate() . '.cart.payment', $data);
    }
}
