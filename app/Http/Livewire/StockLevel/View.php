<?php

namespace App\Http\Livewire\StockLevel;

use Livewire\Component;
use App\Models\SalesStockLevel;


class View extends Component
{
    public $stockLevels;

    public function mount($stockLevels)
    {
        $this->stockLevels = $stockLevels;
    }

    public function render()
    {
        // Eager load the 'product' relationship to avoid N+1 problem
        $this->stockLevels = SalesStockLevel::with('product')->find($this->stockLevels->pluck('id')->toArray());

        return view('livewire.stock-level.view');
    }

}
