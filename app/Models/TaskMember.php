<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskMember extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function members()
    {

        return $this->hasOne(Member::class, 'id', 'memberId');
    }
}
