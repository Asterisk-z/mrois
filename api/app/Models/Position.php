<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DEACTIVATE = "1";
    const ACTIVATE = "0";
    const CCO = "Chief Compliance Officer";

    // protected $with = ['categories'];
    protected $appends = ['active', 'authoriser'];

    public function categories()
    {
        return $this->belongsToMany(MembershipCategory::class, 'membership_category_postitions', 'position_id', 'category_id');
    }

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }
    public function getAuthoriserAttribute()
    {
        return !$this->can_be_authorizer ? true : false;
    }

}
