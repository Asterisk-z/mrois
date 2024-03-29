<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DEACTIVATE = "1";
    const ACTIVATE = "0";

    // protected $with = ['positions'];
    protected $appends = ['active'];

    public function institutions()
    {
        return $this->belongsToMany(Institution::class, 'institution_memberships', 'membership_category_id', 'institution_id');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'membership_category_postitions', 'category_id', 'position_id');
    }

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }

    public function fields() {
        return $this->hasMany(ApplicationField::class, 'category');
    }
}
