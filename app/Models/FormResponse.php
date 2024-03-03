<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'customer_id',
        'checking_code',
        'region_or_route',
        'time_period',
        'image',
        'project_name',
        'feedback_comments',
        'products_available', // Add this field
        'out_of_stock_prods', // Add this field
        'interested_in_new_order',
        'stock_replenishment',
        'expiry_date_update',
        'pricing_accuracy',
        'incorrect_pricing_product_name',
        'incorrect_pricing_current_price',
        'progress_status',
        'new_insights',
        'product_visible',
    ];

    protected $casts = [
        'products_available' => 'array', // Cast JSON fields to array
        'out_of_stock_prods' => 'array', // Cast JSON fields to array
    ];



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

    public function availableProduct()
    {
        return $this->hasMany(SalesStockLevel::class, 'report_id');
    }

    public function availableProducts()
    {
        return $this->hasMany(SalesStockLevel::class, 'report_id');
    }

}
