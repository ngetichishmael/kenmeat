<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnableProduct extends Model
{
    use HasFactory;
    protected $fillable = ['returnable_id', 'product_name', 'quantity'];

    public function returnable()
    {
        return $this->belongsTo(Returnable::class);
    }
}
