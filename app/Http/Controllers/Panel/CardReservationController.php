<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardReservation;
use App\User;
use App\Models\School_level;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CardReservationController extends Controller
{
     /**
      * Display card reservation interface for admin
      */
      public function index(Request $request)
      {
          $authUser = auth()->check() ? auth()->user() : null;
          $query = CardReservation::with('level')->orderBy('created_at', 'desc');
      
          if ($request->filled('level')) {
              $query->where('level_id', $request->level);
          }
      
          if ($request->filled('status')) {
              $query->where('status', $request->status);
          }
      
          if ($request->filled('start_date') && $request->filled('end_date')) {
              $query->whereBetween('created_at', [
                  Carbon::parse($request->start_date)->startOfDay(),
                  Carbon::parse($request->end_date)->endOfDay()
              ]);
          }

          $cardreserve = $query->paginate(10)->appends($request->query());
          $levels = School_level::all();

          return view('admin.financial.cards.reserve', compact('cardreserve', 'authUser', 'levels'));
      }
      
    /**
     * Display card reservation interface for user
     */
    public function create()
    {
        $users =user()->auth();
        $levels = School_level::all();
        $cardreserve= CardReservation::where('enfant_id', $users->id)->where('status','waiting')->get();
        return view('web.default.panel.manules_section_child', compact('users', 'levels','cardreserve'));
    }
    /**
     * Function to store card reservation 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city'=>'required|string',
            'user_id' => 'required|exists:users,id',
            'level_id' => 'required|exists:school_levels,id',
            'enfant_id' => 'required|exists:users,id',
            'phone_number' => 'required|string',
        ]);

        try {
            $cardReservation = CardReservation::create([
                'name' => $request->name,
                'address' => $request->address,
                'city'=>$request->city,
                'user_id' => $request->user_id,
                'level_id' => $request->level_id,
                'enfant_id' => $request->enfant_id,
                'phone_number' => $request->phone_number,
                'status' => CardReservation::STATUS_WAITING,
            ]);
            return redirect()->back()->with('success', 'Card reserved successfully!');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while reserving card!');
        }
    }
    /** 
     * Function to update card reservation
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
        ]);
        $updatecard=CardReservation::find($id);
        try {
            $updatecard->update([
                'name' => $request->name,
                'address' => $request->address,
                'city'=>$request->city,
                'user_id' => $request->user_id,
                'level_id' => $request->level_id,
                'enfant_id' => $request->enfant_id,
                'phone_number' => $request->phone_number,
                'status' => CardReservation::STATUS_WAITING,
            ]);
            return redirect()->back()->with('success', 'Card reserved successfully!');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while reserving card!');
        }
    }
 
    /**
     * Build the HTML for the actions column
     */
    private function buildActionsColumn(CardReservation $res)
    {
        $status = $res->status;
        $html = '<div class="btn-group btn-group-sm">';

        if ($status === CardReservation::STATUS_WAITING) {
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_IN_DELIVERY, 'In Delivery');
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_REJECTED, 'Reject');
        }
        elseif ($status === CardReservation::STATUS_IN_DELIVERY) {
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_DELIVERED, 'Delivered');
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_REJECTED, 'Reject');
        }
        elseif ($status === CardReservation::STATUS_DELIVERED) {
        }
        elseif ($status === CardReservation::STATUS_REJECTED) {
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_IN_DELIVERY, 'In Delivery');
        }
        elseif ($status === CardReservation::STATUS_APPROVED) {
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_IN_DELIVERY, 'In Delivery');
            $html .= $this->makeStatusButton($res->id, CardReservation::STATUS_REJECTED, 'Reject');
        }

        $html .= "<button 
            class='btn btn-danger delete-reservation' 
            data-id='{$res->id}'>
            Delete
        </button>";


        $html .= '</div>';

        return $html;
    }

    /**
     * Helper to create a status-change button with data attributes for JavaScript
     */
    private function makeStatusButton($reservationId, $targetStatus, $label)
    {
        return "<button 
                    class='btn btn-primary change-status' 
                    data-id='{$reservationId}' 
                    data-status='{$targetStatus}'>
                    {$label}
                </button>";
    }

    /**
     * Update status and if status is rejected save note.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:card_reservations,id',
            'status' => 'required|string',
            'rejection_note' => 'nullable|string',
        ]);

        $reservation = CardReservation::findOrFail($request->id);
        $reservation->status = $request->status;

        if ($request->status === CardReservation::STATUS_REJECTED) {
            $reservation->rejection_note = $request->rejection_note;
        } else {
            $reservation->rejection_note = null;
        }

        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }
    /**
     * Delete reservation by ID
     */
    public function destroy($id)
    {
        $reservation = CardReservation::findOrFail($id);
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully!'
        ]);
    }

}
