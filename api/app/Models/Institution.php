<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "status" => $this->is_del ? 'Deactivated' : 'Active',
            "category" => $this->membershipCategories,
            "ars" => $this->ars,
            "application" => $this->application,
        ];
    }

    public function membershipCategories()
    {
        return $this->belongsToMany(MembershipCategory::class, 'institution_memberships', 'institution_id', 'membership_category_id');
    }

    public function ars()
    {
        return $this->hasMany(User::class, 'institution_id', 'id');
    }

    public function application()
    {
        return $this->hasMany(Application::class, 'institution_id', 'id');
    }
}
