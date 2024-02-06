<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;
    protected $table = 'competencies';
    protected $guarded = [];
    protected $with = ['ar'];
    protected $appends = ['evidence_file'];

    public function ar()
    {
        return $this->belongsTo(User::class, 'ar_id', 'id');
    }

    public function framework()
    {
        return $this->belongsTo(CompetencyFramework::class, 'framework_id', 'id');
    }

    public function getEvidenceFileAttribute()
    {
        return $this->evidence ? config('app.url') . '/storage/app/public/' . $this->evidence : null;
    }

}
