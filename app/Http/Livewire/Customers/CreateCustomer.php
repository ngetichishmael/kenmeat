<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\Area;
use App\Models\OutletType;

class CreateCustomer extends Component
{
    public $regions;
    public $subregions;
    public $areas;

    public $selectedRegion = null;
    public $selectedSubregion = null;
    public $selectedArea;

    public function mount()
    {
        $this->regions = Region::all();
    }

    public function updatedSelectedRegion($regionId)
    {
        $this->selectedSubregion = null;
        $this->selectedRegion = $regionId;
        $this->subregions = Subregion::where('region_id', $regionId)->get();
    }

    public function updatedSelectedSubregion($subregionId)
    {
        $this->selectedSubregion = $subregionId;
        $this->areas = Area::where('subregion_id', $subregionId)->get();
    }

    public function render()
    {
        $regions = Region::all();
        $outlets = OutletType::all();

        $subregions = [];
        if ($this->selectedRegion) {
            $subregions = Subregion::where('region_id', $this->selectedRegion)->get();
        }

        $areas = [];
        if ($this->selectedSubregion) {
            $areas = Area::where('subregion_id', $this->selectedSubregion)->get();
        }

        return view('livewire.customers.create-customer', compact('regions', 'subregions','outlets', 'areas'));
    }
}
