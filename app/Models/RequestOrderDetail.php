<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requestOrder() {
        return $this->belongsTo(RequestOrder::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
