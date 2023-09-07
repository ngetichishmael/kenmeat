<?php

namespace App\Exports;

use App\Models\warehousing;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WarehousesExport implements FromQuery, WithHeadings
{
    protected $orderBy;
    protected $orderAsc;
    protected $searchTerm;
    protected $user;

    public function __construct($orderBy, $orderAsc, $searchTerm)
    {
        $this->orderBy = $orderBy;
        $this->orderAsc = $orderAsc;
        $this->searchTerm = $searchTerm;
        $this->user = Auth::user();
    }

    public function query()
    {
        $query = warehousing::with(['region:name', 'subregion:name'])
            ->withCount('productInformation')
            ->select([
                'warehouse.id',
                'warehouse.name',
                'region.name as region', // Use 'region.name' from the related table
                'subregion.name as sub_region', // Use 'subregion.name' from the related table
                'warehouse.status',
                // Add more columns here as needed
            ]);
    
        if ($this->user->account_type === "Managers") {
            $query->whereIn('region_id', $this->filter());
        }
    
        if ($this->searchTerm) {
            $query->where('warehouse.name', 'LIKE', '%' . $this->searchTerm . '%');
        }
    
        return $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
    }
    
    

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Region',
            'Sub Region',
            'Status',
            'Products Count',
        ];
    }
}
