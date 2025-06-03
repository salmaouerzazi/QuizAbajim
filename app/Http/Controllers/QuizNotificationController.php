<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizNotification;
use App\QuizNotificationUsers;
use App\User;
use App\Events\QuizNotificationSent;

class QuizNotificationController extends Controller
{
    public function sendToLevel(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'nullable|string',
            'level_id' => 'required|integer',
            'quiz_id' => 'nullable|integer',
        ]);

        // Crée la notification principale
        $notification = QuizNotification::create([
            'title' => $request->title,
            'message' => $request->message,
            'quiz_id' => $request->quiz_id,
            'sender_type' => 'admin',
            'sender_id' => auth()->id(),
            'target_type' => 'multiple',
        ]);

        // Récupère tous les enfants du niveau
        $children = User::where('role', 'child')->where('level_id', $request->level_id)->get();

        // Crée les notifications individuelles et les broadcaste
        foreach ($children as $child) {
            $notifUser = QuizNotificationUsers::create([
                'notification_id' => $notification->id,
                'receiver_id' => $child->id,
            ]);

            // Broadcast à l’enfant en live
            event(new QuizNotificationSent($notifUser));
        }

        return response()->json(['message' => '✅ Notification envoyée avec succès.']);
    }

    /**
     */
    public function listForChild()
    {
        $childId = auth()->id();

        $notifications = \App\QuizNotificationUsers::with('notification')->where('receiver_id', $childId)->orderByDesc('created_at')->get();

        return view('web.default.includes.notifications', compact('notifications'));
    }
    public function ajaxNotifications()
    {
        try {
            $user = auth()->user();
    
            $notifications = \App\QuizNotificationUsers::with([
                'notification.quiz.model.webinar'
            ])
            ->where('receiver_id', $user->id)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();
    
            $unreadCount = $notifications->where('is_read', false)->count();
    
            if (view()->exists('web.default.includes.notification_dropdown')) {
                $html = view('web.default.includes.notification_dropdown', compact('notifications', 'unreadCount'))->render();
            } elseif (view()->exists('web.default.includes.notification-dropdown')) {
                $html = view('web.default.includes.notification-dropdown', compact('notifications', 'unreadCount'))->render();
            } else {
                $html = '<div>Notifications: ' . $unreadCount . '</div>';
            }
    
            return response()->json([
                'html' => $html,
                'unreadCount' => $unreadCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur dans ajaxNotifications: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    


    /**
     */
    public function markAsRead($id)
    {
        $notifUser = QuizNotificationUsers::findOrFail($id);
        $notifUser->update(['is_read' => true]);

        return response()->json(['message' => '✅ Notification marquée comme lue.']);
    }
}
