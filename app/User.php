<?php

namespace App;

use App\Bitwise\UserLevelOfTraining;
use App\Models\Accounting;
use App\Models\Badge;
use App\Models\ForumTopic;
use App\Models\ForumTopicLike;
use App\Models\ForumTopicPost;
use App\Models\Meeting;
use App\Models\Noticeboard;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\ProductOrder;
use App\Models\QuizzesResult;
use App\Models\Region;
use App\Models\ReserveMeeting;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Sale;
use App\Models\Section;
use App\Models\Webinar;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Models\Video;
use App\Models\NotificationTemplateTranslation;
use App\Models\SubscribeUse;
use App\QuizNotificationUsers;

class User extends Authenticatable
{
    use Notifiable;

    static $active = 'active';
    static $pending = 'pending';
    static $inactive = 'inactive';

    protected $dateFormat = 'U';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token', 'google_id', 'facebook_id', 'role_id'];

    static $statuses = ['active', 'pending', 'inactive'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'level_of_training' => 'integer',
        'guide_progress' => 'array',
    ];
    private $permissions;
    private $user_group;
    private $userInfo;

    public function enfant()
    {
        return $this->hasOne(Enfant::class, 'user_id');
    }
    public function quizNotifications()
    {
        return $this->hasMany(QuizNotificationUsers::class, 'receiver_id');
    }

    public function isOnline()
    {
        // Set threshold (e.g., 5 minutes)
        $threshold = Carbon::now('Africa/Tunis')->subMinutes(1);
        // Check if the user was last seen within the threshold
        return $this->last_seen_at && $this->last_seen_at > $threshold;
    }
    public function viewedVideos()
    {
        return $this->belongsToMany(Video::class, 'user_views');
    }

    static function getAdmin()
    {
        $role = Role::where('name', Role::$admin)->first();

        $admin = self::where('role_name', $role->name)->where('role_id', $role->id)->first();

        return $admin;
    }
    public function levels()
    {
        return $this->belongsToMany('App\Models\School_level', 'user_matiere', 'teacher_id', 'level_id');
    }

    public function childLevel()
    {
        return $this->belongsTo('App\Models\School_level', 'level_id');
    }

    public function materials()
    {
        return $this->belongsToMany('App\Models\Material', 'user_matiere', 'teacher_id', 'matiere_id');
    }
    public function subscriptions1()
    {
        return $this->belongsToMany(User::class, 'teachers', 'users_id', 'teacher_id');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'teachers', 'teacher_id', 'users_id');
    }
    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id');
    }
    public function subscribers1()
    {
        return $this->belongsToMany(User::class, 'teachers', 'teacher_id', 'users_id');
    }
    public function isAdmin()
    {
        return $this->role_name === Role::$admin;
    }

    public function isUser()
    {
        return $this->role_name === Role::$user;
    }

    public function isTeacher()
    {
        return $this->role_name === Role::$teacher;
    }
    public function isEnfant()
    {
        return $this->role_name === Role::$enfant;
    }
    public function isOrganization()
    {
        return $this->role_name === Role::$organization;
    }

    public function hasPermission($section_name)
    {
        if (self::isAdmin()) {
            if (!isset($this->permissions)) {
                $sections_id = Permission::where('role_id', '=', $this->role_id)->where('allow', true)->pluck('section_id')->toArray();
                $this->permissions = Section::whereIn('id', $sections_id)->pluck('name')->toArray();
            }
            return in_array($section_name, $this->permissions);
        }
        return false;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function getAvatar($size = 40)
    {
        if (!empty($this->avatar)) {
            $avatarUrl = $this->avatar;
        } else {
            $avatarUrl = "/getDefaultAvatar?item={$this->id}&name={$this->full_name}&size=$size";
        }

        return $avatarUrl;
    }

    public function getCover()
    {
        if (!empty($this->cover_img)) {
            $path = str_replace('/storage', '', $this->cover_img);

            $imgUrl = url($path);
        } else {
            $imgUrl = getPageBackgroundSettings('user_cover');
        }

        return $imgUrl;
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function getProfileUrl()
    {
        return '/users/' . $this->id . '/profile';
    }

    public function getLevelOfTrainingAttribute()
    {
        $levels = null;
        $bit = $this->attributes['level_of_training'];

        if (!empty($bit) and is_string($bit)) {
            // in host with mariaDB
            try {
                $tmp = (int) bin2hex($bit);

                if (is_numeric($tmp) and $tmp > 0 and $tmp <= 7) {
                    $bit = $tmp;
                }
            } catch (\Exception $exception) {
            }
        }

        if (!empty($bit) and is_numeric($bit)) {
            $levels = (new UserLevelOfTraining())->getName($bit);

            if (!empty($levels) and !is_array($levels)) {
                $levels = [$levels];
            }
        }

        return $levels;
    }

    public function getUserGroup()
    {
        if (empty($this->user_group)) {
            if (!empty($this->userGroup) and !empty($this->userGroup->group) and $this->userGroup->group->status == 'active') {
                $this->user_group = $this->userGroup->group;
            }
        }

        return $this->user_group;
    }

    public static function generatePassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function meeting()
    {
        return $this->hasOne('App\Models\Meeting', 'teacher_id', 'id');
    }

    public function hasMeeting()
    {
        return Meeting::where('disabled', false)->where('teacher_id', $this->id)->first();
    }

    public function ReserveMeetings()
    {
        return $this->hasMany('App\Models\ReserveMeeting', 'user_id', 'id');
    }

    public function affiliateCode()
    {
        return $this->hasOne('App\Models\AffiliateCode', 'user_id', 'id');
    }

    public function following()
    {
        return Follow::where('follower', $this->id)->where('status', Follow::$accepted)->get();
    }

    public function webinars()
    {
        return $this->hasMany('App\Models\Webinar', 'creator_id', 'id')->orWhere('teacher_id', $this->id);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'creator_id', 'id');
    }

    public function productOrdersAsBuyer()
    {
        return $this->hasMany('App\Models\ProductOrder', 'buyer_id', 'id');
    }

    public function productOrdersAsSeller()
    {
        return $this->hasMany('App\Models\ProductOrder', 'seller_id', 'id');
    }

    public function forumTopics()
    {
        return $this->hasMany('App\Models\ForumTopic', 'creator_id', 'id');
    }

    public function forumTopicPosts()
    {
        return $this->hasMany('App\Models\ForumTopicPost', 'user_id', 'id');
    }

    public function blog()
    {
        return $this->hasMany('App\Models\Blog', 'author_id', 'id');
    }

    public function getActiveWebinars($just_count = false)
    {
        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) {
                $query->where('creator_id', $this->id)->orWhere('teacher_id', $this->id);
            })
            ->orderBy('created_at', 'desc');

        if ($just_count) {
            return $webinars->count();
        }

        return $webinars->get();
    }

    public function userMetas()
    {
        return $this->hasMany('App\Models\UserMeta');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'creator_id', 'id');
    }

    public function userGroup()
    {
        return $this->belongsTo('App\Models\GroupUser', 'id', 'user_id');
    }
    public function matier()
    {
        return $this->belongsTo('App\Models\Material', 'id', 'matier_id');
    }
    public function students()
    {
        return $this->hasMany(User::class, 'organ_id');
    }
    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate', 'student_id', 'id');
    }

    public function customBadges()
    {
        return $this->hasMany('App\Models\UserBadge', 'user_id', 'id');
    }

    public function supports()
    {
        return $this->hasMany('App\Models\Support', 'user_id', 'id');
    }

    public function occupations()
    {
        return $this->hasMany('App\Models\UserOccupation', 'user_id', 'id');
    }

    public function userRegistrationPackage()
    {
        return $this->hasOne('App\Models\UserRegistrationPackage', 'user_id', 'id');
    }

    public function organization()
    {
        return $this->hasOne($this, 'id', 'organ_id');
    }

    public function getOrganizationTeachers()
    {
        return $this->hasMany($this, 'organ_id', 'id')->where('role_name', Role::$teacher);
    }

    public function getOrganizationStudents()
    {
        return $this->hasMany($this, 'organ_id', 'id')->where('role_name', Role::$enfant);
    }

    public function zoomApi()
    {
        return $this->hasOne('App\Models\UserZoomApi', 'user_id', 'id');
    }
    public function subscriptions()
    {
        return $this->hasMany(SubscribeUse::class, 'user_id', 'id');
    }

    public function rates()
    {
        $webinars = $this->webinars()->where('status', 'active')->get();

        $rate = 0;

        if (!empty($webinars)) {
            $rates = 0;
            $count = 0;

            foreach ($webinars as $webinar) {
                $webinarRate = $webinar->getRate();

                if (!empty($webinarRate) and $webinarRate > 0) {
                    $count += 1;
                    $rates += $webinarRate;
                }
            }

            if ($rates > 0) {
                if ($count < 1) {
                    $count = 1;
                }

                $rate = number_format($rates / $count, 2);
            }
        }

        return $rate;
    }

    public function reviewsCount()
    {
        $webinars = $this->webinars;
        $count = 0;

        if (!empty($webinars)) {
            foreach ($webinars as $webinar) {
                $count += $webinar->reviews->count();
            }
        }

        return $count;
    }

    public function getBadges($customs = true, $getNext = false)
    {
        return Badge::getUserBadges($this, $customs, $getNext);
    }

    public function getCommission()
    {
        $commission = 0;
        $financialSettings = getFinancialSettings();

        if (!empty($financialSettings) and !empty($financialSettings['commission'])) {
            $commission = (int) $financialSettings['commission'];
        }

        $getUserGroup = $this->getUserGroup();
        if (!empty($getUserGroup) and isset($getUserGroup->commission)) {
            $commission = $getUserGroup->commission;
        }

        if (!empty($this->commission)) {
            $commission = $this->commission;
        }

        return $commission;
    }

    public function getIncome()
    {
        $totalIncome = Accounting::where('user_id', $this->id)->where('type_account', Accounting::$income)->where('type', Accounting::$addiction)->where('system', false)->where('tax', false)->sum('amount');

        return $totalIncome;
    }

    public function getPayout()
    {
        $credit = Accounting::where('user_id', $this->id)->where('type_account', Accounting::$income)->where('type', Accounting::$addiction)->where('system', false)->where('tax', false)->sum('amount');

        $debit = Accounting::where('user_id', $this->id)->where('type_account', Accounting::$income)->where('type', Accounting::$deduction)->where('system', false)->where('tax', false)->sum('amount');

        return $credit - $debit;
    }

    public function getAccountingCharge()
    {
        $query = Accounting::where('user_id', $this->id)->where('type_account', Accounting::$asset)->where('system', false)->where('tax', false);

        $additions = deepClone($query)->where('type', Accounting::$addiction)->sum('amount');

        $deductions = deepClone($query)->where('type', Accounting::$deduction)->sum('amount');

        $charge = $additions - $deductions;
        return $charge > 0 ? $charge : 0;
    }

    public function getAccountingBalance()
    {
        $additions = Accounting::where('user_id', $this->id)->where('type', Accounting::$addiction)->where('system', false)->where('tax', false)->sum('amount');

        $deductions = Accounting::where('user_id', $this->id)->where('type', Accounting::$deduction)->where('system', false)->where('tax', false)->sum('amount');

        $balance = $additions - $deductions;
        return $balance > 0 ? $balance : 0;
    }

    public function getPurchaseAmounts()
    {
        return Sale::where('buyer_id', $this->id)->sum('amount');
    }

    public function getSaleAmounts()
    {
        return Sale::where('seller_id', $this->id)->whereNull('refund_at')->sum('amount');
    }

    public function sales()
    {
        $webinarIds = Webinar::where('creator_id', $this->id)->pluck('id')->toArray();

        return Sale::whereIn('webinar_id', $webinarIds)->sum('amount');
    }

    public function salesCount()
    {
        return Sale::where('seller_id', $this->id)->whereNotNull('webinar_id')->where('type', 'webinar')->whereNull('refund_at')->count();
    }

    public function productsSalesCount()
    {
        return Sale::where('seller_id', $this->id)->whereNotNull('product_order_id')->where('type', 'product')->whereNull('refund_at')->count();
    }

    public function getUnReadNotifications()
    {
        $notifications = Notification::where(function ($query) {
            $query
                ->where(function ($query) {
                    $query->where('user_id', $this->id)->where('type', 'single');
                })
                ->orWhere(function ($query) {
                    if (!$this->isAdmin()) {
                        $query->whereNull('user_id')->whereNull('group_id')->where('type', 'all_users');
                    }
                });
        })
            ->orderBy('created_at', 'desc')
            ->get();

        $userGroup = $this->userGroup()->first();
        if (!empty($userGroup)) {
            $groupNotifications = Notification::where('group_id', $userGroup->group_id)->where('type', 'group')->doesntHave('notificationStatus')->orderBy('created_at', 'desc')->get();

            if (!empty($groupNotifications) and !$groupNotifications->isEmpty()) {
                $notifications = $notifications->merge($groupNotifications);
            }
        }

        if ($this->isUser()) {
            $studentsNotifications = Notification::whereNull('user_id')->whereNull('group_id')->where('type', 'students')->doesntHave('notificationStatus')->orderBy('created_at', 'desc')->get();
            if (!empty($studentsNotifications) and !$studentsNotifications->isEmpty()) {
                $notifications = $notifications->merge($studentsNotifications);
            }
        }

        if ($this->isTeacher()) {
            $instructorNotifications = Notification::whereNull('user_id')->whereNull('group_id')->where('type', 'instructors')->orderBy('created_at', 'desc')->get();
            if (!empty($instructorNotifications) and !$instructorNotifications->isEmpty()) {
                $notifications = $notifications->merge($instructorNotifications);
            }
        }

        if ($this->isOrganization()) {
            $organNotifications = Notification::whereNull('user_id')->whereNull('group_id')->where('type', 'organizations')->doesntHave('notificationStatus')->orderBy('created_at', 'desc')->get();
            if (!empty($organNotifications) and !$organNotifications->isEmpty()) {
                $notifications = $notifications->merge($organNotifications);
            }
        }

        return $notifications;
    }
    //     public function getUnReadNotifications()
    // {
    //     $locale = app()->getLocale();

    //     $notifications = \App\Models\NotificationTemplateTranslation::where('language', $locale)
    //         ->whereHas('template.notification', function ($query) {
    //             $query->where(function ($query) {
    //                 $query->where(function ($query) {
    //                     $query->where('user_id', $this->id)
    //                           ->where('type', 'single');
    //                 })->orWhere(function ($query) {
    //                     if (!$this->isAdmin()) {
    //                         $query->whereNull('user_id')
    //                               ->whereNull('group_id')
    //                               ->where('type', 'all_users');
    //                     }
    //                 });
    //             });
    //         })
    //         ->whereDoesntHave('template.notification.notificationStatus')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     //------> Group notifications
    //     $userGroup = $this->userGroup()->first();
    //     if (!empty($userGroup)) {
    //         $groupNotifications = \App\Models\NotificationTemplateTranslation::where('language', $locale)
    //             ->whereHas('template.notification', function ($query) use ($userGroup) {
    //                 $query->where('group_id', $userGroup->group_id)
    //                       ->where('type', 'group');
    //             })
    //             ->whereDoesntHave('template.notification.notificationStatus')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         if (!empty($groupNotifications) && !$groupNotifications->isEmpty()) {
    //             $notifications = $notifications->merge($groupNotifications);
    //         }
    //     }

    //     //--------> Childs notifications
    //     if ($this->isUser()) {
    //         $studentsNotifications = \App\Models\NotificationTemplateTranslation::where('language', $locale)
    //             ->whereHas('template.notification', function ($query) {
    //                 $query->whereNull('user_id')
    //                       ->whereNull('group_id')
    //                       ->where('type', 'students');
    //             })
    //             ->whereDoesntHave('template.notification.notificationStatus')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         if (!empty($studentsNotifications) && !$studentsNotifications->isEmpty()) {
    //             $notifications = $notifications->merge($studentsNotifications);
    //         }
    //     }

    //     //-------> Teachers notifications
    //     if ($this->isTeacher()) {
    //         $instructorNotifications = \App\Models\NotificationTemplateTranslation::where('language', $locale)
    //             ->whereHas('template.notification', function ($query) {
    //                 $query->whereNull('user_id')
    //                       ->whereNull('group_id')
    //                       ->where('type', 'instructors');
    //             })
    //             ->whereDoesntHave('template.notification.notificationStatus')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         if (!empty($instructorNotifications) && !$instructorNotifications->isEmpty()) {
    //             $notifications = $notifications->merge($instructorNotifications);
    //         }
    //     }

    //     //----> Parent notifications
    //     if ($this->isOrganization()) {
    //         $organNotifications = \App\Models\NotificationTemplateTranslation::where('language', $locale)
    //             ->whereHas('template.notification', function ($query) {
    //                 $query->whereNull('user_id')
    //                       ->whereNull('group_id')
    //                       ->where('type', 'organizations');
    //             })
    //             ->whereDoesntHave('template.notification.notificationStatus')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         if (!empty($organNotifications) && !$organNotifications->isEmpty()) {
    //             $notifications = $notifications->merge($organNotifications);
    //         }
    //     }

    //     return $notifications;
    // }

    public function getUnreadNoticeboards()
    {
        $purchasedCoursesIds = $this->getPurchasedCoursesIds();
        $purchasedCoursesInstructorsIds = Webinar::whereIn('id', $purchasedCoursesIds)->pluck('teacher_id')->toArray();

        $noticeboards = Noticeboard::where(function ($query) {
            $query
                ->whereNotNull('organ_id')
                ->where('organ_id', $this->organ_id)
                ->where(function ($query) {
                    if ($this->isOrganization()) {
                        $query->where('type', 'organizations');
                    } else {
                        $type = 'students';

                        if ($this->isTeacher()) {
                            $type = 'instructors';
                        }

                        $query->whereIn('type', ['students_and_instructors', $type]);
                    }
                });
        })
            ->orWhere(function ($query) {
                $type = ['all'];

                if ($this->isUser()) {
                    $type = array_merge($type, ['students', 'students_and_instructors']);
                } elseif ($this->isTeacher()) {
                    $type = array_merge($type, ['instructors', 'students_and_instructors']);
                } elseif ($this->isOrganization()) {
                    $type = array_merge($type, ['organizations']);
                }

                $query->whereNull('organ_id')->whereNull('instructor_id')->whereIn('type', $type);
            })
            ->orWhere(function ($query) use ($purchasedCoursesInstructorsIds) {
                $query->whereNull('webinar_id')->whereIn('instructor_id', $purchasedCoursesInstructorsIds);
            })
            ->orWhere(function ($query) use ($purchasedCoursesIds) {
                $query->whereIn('webinar_id', $purchasedCoursesIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        /*
        ->whereDoesntHave('noticeboardStatus', function ($qu) {
            $qu->where('user_id', $this->id);
        })
        */

        return $noticeboards;
    }

    public function getPurchasedCoursesIds()
    {
        $webinarIds = [];

        $sales = Sale::where('buyer_id', $this->id)->whereNotNull('webinar_id')->where('type', 'webinar')->whereNull('refund_at')->get();

        foreach ($sales as $sale) {
            if ($sale->payment_method == Sale::$subscribe) {
                $subscribe = $sale->getUsedSubscribe($sale->buyer_id, $sale->webinar_id);

                if (!empty($subscribe)) {
                    $subscribeSale = Sale::where('buyer_id', $this->id)->where('type', Sale::$subscribe)->where('subscribe_id', $subscribe->id)->whereNull('refund_at')->latest('created_at')->first();

                    if (!empty($subscribeSale)) {
                        $usedDays = (int) diffTimestampDay(time(), $subscribeSale->created_at);
                        if ($usedDays <= $subscribe->days) {
                            $webinarIds[] = $sale->webinar_id;
                        }
                    }
                }
            } else {
                $webinarIds[] = $sale->webinar_id;
            }
        }

        return $webinarIds;
    }

    public function getActiveQuizzesResults($group_by_quiz = false, $status = null)
    {
        $query = QuizzesResult::where('user_id', $this->id);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if ($group_by_quiz) {
            $query->groupBy('quiz_id');
        }

        return $query->get();
    }

    public function getTotalHoursTutoring()
    {
        $seconds = 0;

        if (!empty($this->meeting)) {
            $meetingId = $this->meeting->id;

            $reserves = ReserveMeeting::where('meeting_id', $meetingId)->where('status', 'finished')->get();

            if (!empty($reserves)) {
                foreach ($reserves as $reserve) {
                    $meetingTime = $reserve->meetingTime;

                    if ($meetingTime) {
                        $time = explode('-', $meetingTime->time);

                        $start = strtotime($time[0]);
                        $end = strtotime($time[1]);

                        $seconds = $end - $start;
                    }
                }
            }
        }

        $hours = $seconds ? $seconds / (60 * 60) : 0;

        return round($hours, 0, PHP_ROUND_HALF_UP);
    }

    public function getRewardPoints()
    {
        $credit = RewardAccounting::where('user_id', $this->id)->where('status', RewardAccounting::ADDICTION)->sum('score');

        $debit = RewardAccounting::where('user_id', $this->id)->where('status', RewardAccounting::DEDUCTION)->sum('score');

        return $credit - $debit;
    }

    public function getAddress($full = false)
    {
        $address = null;

        if ($full) {
            $regionIds = [$this->country_id, $this->province_id, $this->city_id, $this->district_id];

            $regions = Region::whereIn('id', $regionIds)->get();

            foreach ($regions as $region) {
                if ($region->id == $this->country_id) {
                    $address .= $region->title;
                } elseif ($region->id == $this->province_id) {
                    $address .= ', ' . $region->title;
                } elseif ($region->id == $this->city_id) {
                    $address .= ', ' . $region->title;
                } elseif ($region->id == $this->district_id) {
                    $address .= ', ' . $region->title;
                }
            }
        }

        if (!empty($address)) {
            $address .= ', ';
        }

        $address .= $this->address;

        return $address;
    }

    public function getWaitingDeliveryProductOrdersCount()
    {
        return ProductOrder::where('seller_id', $this->id)->where('status', ProductOrder::$waitingDelivery)->count();
    }

    public function checkCanAccessToStore()
    {
        $result = (!empty(getStoreSettings('status')) and getStoreSettings('status'));

        if (!$result) {
            $result = $this->can_create_store;
        }

        return $result;
    }

    public function getTopicsPostsCount()
    {
        $topics = ForumTopic::where('creator_id', $this->id)->count();
        $posts = ForumTopicPost::where('user_id', $this->id)->count();

        return $topics + $posts;
    }

    public function getTopicsPostsLikesCount()
    {
        $topicsIds = ForumTopic::where('creator_id', $this->id)->pluck('id')->toArray();
        $postsIds = ForumTopicPost::where('user_id', $this->id)->pluck('id')->toArray();

        $topicsLikes = ForumTopicLike::whereIn('topic_id', $topicsIds)->count();
        $postsLikes = ForumTopicLike::whereIn('topic_post_id', $postsIds)->count();

        return $topicsLikes + $postsLikes;
    }

    public function getCountryAndState()
    {
        $address = null;

        if (!empty($this->country_id)) {
            $country = Region::where('id', $this->country_id)->first();

            if (!empty($country)) {
                $address .= $country->title;
            }
        }

        if (!empty($this->province_id)) {
            $province = Region::where('id', $this->province_id)->first();

            if (!empty($province)) {
                if (!empty($address)) {
                    $address .= '/';
                }

                $address .= $province->title;
            }
        }

        return $address;
    }

    public function getRegionByTypeId($typeId, $justTitle = true)
    {
        $region = !empty($typeId) ? Region::where('id', $typeId)->first() : null;

        if (!empty($region)) {
            return $justTitle ? $region->title : $region;
        }

        return '';
    }
}
