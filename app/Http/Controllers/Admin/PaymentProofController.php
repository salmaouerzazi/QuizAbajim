<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Subscribe;

class PaymentProofController extends Controller
{
    public function index(Request $request)
    {
        // $this->authorize('admin_payment_proof_list');

        $proofs = PaymentProof::query();

         $proofs = $this->filters($proofs, $request)
         ->orderBy('created_at', 'desc')
         ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/paymentProofs.payment_proofs'),
            'proofs' => $proofs
        ];

        return view('admin.financial.paymentProofs.payment_proof', $data);
    }
    private function filters($query, $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $users = $request->input('user');
        $status = $request->input('status');

        if (!empty($from) && !empty($to)) {
            $query->whereBetween('created_at', [$from, $to]);
        }

        if (!empty($users)) {
            $query->whereIn('user_id', $users);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note' => 'nullable|string|max:255',
        ]);

        $proof = PaymentProof::findOrFail($id);
        $proof->status = $request->status;
        $proof->approved_by = Auth::id();

        if ($request->status === 'rejected') {
            $proof->note = $request->note;
            $proof->save();
            return response()->json(['success' => true, 'message' => trans('admin/main.status_updated')]);
        }

        $order = Order::create([
            'user_id' => $proof->user_id,
            'status' => 'paid',
            'amount' => 120, // Static amount for now TODO:: Change to dynamic
            'tax' => 0,
            'total_discount' => 0,
            'total_amount' => 120, // Static amount for now TODO:: Change to dynamic
            'reference_id' => $proof->id,
            'created_at' => now()->timestamp,
        ]);

        OrderItem::create([
            'user_id' => $proof->user_id,
            'order_id' => $order->id,
            'model_type' => Subscribe::class,
            'model_id' => 3 , // Static model id for now TODO:: Change to dynamic
            'amount' => 120 , // Static amount for now TODO:: Change to dynamic
            'tax' => 0,
            'commission' => 0,
            'discount' => 0,
            'total_amount' => 120, // Static amount for now TODO:: Change to dynamic
            'created_at' => now()->timestamp,
        ]);

        $proof->save();

        return response()->json(['success' => true, 'message' => trans('admin/main.status_updated')]);
    }

}
