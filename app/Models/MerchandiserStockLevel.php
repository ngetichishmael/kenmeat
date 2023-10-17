<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchandiserStockLevel extends Model
{
    use HasFactory;

    protected $table ='merchandiser_stock_level';

    protected $guarded= [];

    public function report() {
        return $this->belongsTo(MerchandiserReport::class, 'report_id');
    }
}
