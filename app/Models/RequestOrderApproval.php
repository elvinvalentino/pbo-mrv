<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOrderApproval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requestOrder() {
        return $this->belongsTo(RequestOrder::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
