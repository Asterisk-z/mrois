<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    const APPROVED = "approved";
    const DECLINED = "declined";
    const PENDING = "pending";

    protected $with = ['role', 'userNationality']; // almost all use of user model requires this information.
    protected $appends = ['full_name', 'full_name_with_mail', 'is_active'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(ComplaintComment::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function category()
    {
        return $this->belongsTo(MembershipCategory::class, 'category_id');
    }

    public function userNationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality', 'code');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function passwords()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function competency_response()
    {
        return $this->hasMany(Competency::class, 'ar_id', 'id');
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getBasicData($includePosition = false): array
    {
        $data = [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'middleName' => $this->middle_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'nationality' => $this->userNationality->name,
            'role' => $this->role->name,
            'approval_status' => $this->approval_status,
            'regId' => $this->reg_id,
            'institution' => $this->institution->name ?? null,
            'createdAt' => $this->created_at,
        ];

        // if ($includePosition) {
        //     $data['position'] = $this->position->name;
        // }

        return $data;
    }

    /**
     * getRegID returns the regID if existing. Else, it created one and updates the user record.
     * @return string
     **/
    public function getRegID(): string
    {
        if ($this->reg_id) {
            return $this->reg_id;
        }

        return $this->createRegID();
    }

    public function getFullNameAttribute()
    {
        $middleName = $this->middle_name ? " $this->middle_name " : " ";
        return $this->first_name . $middleName . $this->last_name;
    }

    public function getFullNameWithMailAttribute()
    {
        return $this->first_name . " " . $this->last_name . " (" . $this->email . ")";
    }
    public function getIsActiveAttribute()
    {
        return $this->member_status == 'active';
    }

    private function createRegID(): string
    {
        $this->reg_id = 'FMDQX/MB-' . str_pad($this->id, 4, "0", STR_PAD_LEFT) . date("Ymd", strtotime($this->created_at));

        $this->update(['reg_id' => $this->reg_id]);

        return $this->reg_id;

        //FMDQ/MB-SERIALNO+FULL JOIN DATE
    }

    public function createRegIDAr(): string
    {
        $this->reg_id = 'FMDQX/AR-' . str_pad($this->id, 4, "0", STR_PAD_LEFT) . date("Ymd", strtotime($this->created_at));

        $this->update(['reg_id' => $this->reg_id]);

        return $this->reg_id;

        //FMDQ/MB-SERIALNO+FULL JOIN DATE
    }

    public function application()
    {
        return $this->hasMany(Application::class, 'submitted_by');
    }

    public static function STAKEHOLDER_DATA($email, $firstname = null, $lastname = null)
    {
        $count_stake_holder = (User::where('role_id', Role::STAKEHOLDER)->count()) + 1;
        return [
            'first_name' => $firstname ? $firstname : "stakeholder" . $count_stake_holder,
            'last_name' => $lastname ? $lastname : "stakeholder" . $count_stake_holder,
            'nationality' => 'NG',
            'email' => $email,
            'phone' => rand(100000, 999999999) . $count_stake_holder,
            'approval_status' => 'pending',
            'role_id' => Role::STAKEHOLDER,
            'institution_id' => null,
            'position_id' => null,
            'verified_at' => now(),
        ];

    }
}
