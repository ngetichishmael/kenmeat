<?php

namespace App\Models;

use App\Models\customer\customers;
use App\Models\products\product_information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returnable extends Model
{
    use HasFactory;
    protected $guarded = ['returnables'];

    public function product()
    {
        return $this->belongsTo(product_information::class);
    }

    public function customer()
    {
        return $this->belongsTo(customers::class);
    }
}
