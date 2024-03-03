<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesStockLevel extends Model
{
    use HasFactory;

    protected $table ='sales_available_products';

    protected $guarded= [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function customer()
    {
        return $this->belongsTo(customers::class, 'customer_id'); 
    }

    public function product()
    {
        return $this->belongsTo(ProductInformation::class, 'product_id');
    }


}
