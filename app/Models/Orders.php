<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table = 'orders';

    protected $fillable = [
        'id',
        'user_id',
        'date',
        'total_price',
    ];

    public function user()
	{
	      return $this->belongsTo(User::class);
	}

	public function detail_orders()
	{
	     return $this->hasMany(DetailOrders::class);
	}
}
