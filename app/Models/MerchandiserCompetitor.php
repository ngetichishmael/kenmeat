<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchandiserCompetitor extends Model
{
    use HasFactory;

    protected $table ='merchandiser_competitors';

    protected $guarded= [];

    public function report() {
        return $this->belongsTo(MerchandiserReport::class, 'report_id');
    }
}
