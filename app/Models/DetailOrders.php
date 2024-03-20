<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrders extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function products()
	{
	      return $this->belongsTo(Products::class);
	}

	public function orders()
	{
	      return $this->belongsTo(Orders::class);
	}
}
