<?php

namespace App\Models;

use App\Models\products\ProductSku;
use App\Models\products\product_inventory;
use App\Models\products\product_price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductInformation extends Model
{
    use HasFactory;
    protected $table = 'product_information';
    protected $guarded = [];

    /**
     * Get the ProductPrice associated with the product_information
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ProductPrice(): HasOne
    {
        return $this->hasOne(product_price::class, 'productID', 'id');
    }
    /**
     * Get the Inventory associated with the product_information
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Inventory(): HasOne
    {
        return $this->hasOne(product_inventory::class, 'productID', 'id');
    }
    public function ProductSKU()
    {
        return $this->hasMany(ProductSku::class, 'sku_code', 'sku_code');
    }
    public function warehouse()
    {
        return $this->belongsTo(warehousing::class, 'warehouse_code', 'warehouse_code');
    }

    public function salesStockLevels()
    {
        return $this->hasMany(SalesStockLevel::class, 'product_id');
    }
    
}
