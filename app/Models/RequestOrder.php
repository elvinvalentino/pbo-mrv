<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function requestOrderDetails() {
      return  $this->hasMany(RequestOrderDetail::class);
    }

    public function requestOrderApprovals() {
      return $this->hasMany(RequestOrderApproval::class);
    }
}
