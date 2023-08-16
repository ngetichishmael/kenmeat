<?php
// app/Http/Livewire/Maps/Agents/Dashboard.php
namespace App\Http\Livewire\Maps\Agents;

use App\Models\CurrentDeviceInformation;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $typeMap = 'roadmap';
    public $customerListVisible = true;
    public $mapMarkers = [];
    public $selectedDate;
    public $search = null;

    // A method to set the selected date (you can call this method when the date changes)
    public function setDate($date)
    {
        $this->selectedDate = $date;
    }

    public function render()
    {
        $initialMarkers = [];
        $information = CurrentDeviceInformation::orderBy('id', 'ASC')->get();
        $data = $information->groupBy('user_code');
        $markersByTitle = [];

        // Get the search term from the $search property
        $searchTerm = trim($this->search);

        // If a search term is provided, filter the $data collection based on the user name
        if ($searchTerm) {
            $data = $data->filter(function ($value) use ($searchTerm) {
                $userName = User::where('user_code', $value->first()->user_code)->pluck('name')->implode('');
                return str_contains(strtolower($userName), strtolower($searchTerm));
            });
        }

        foreach ($data as $value) {
            foreach ($value as $info) {
                $myArray = explode(',', $info['current_gps']);
                $array = [
                    'title' => User::where('user_code', $info->user_code)->pluck('name')->implode(''),
                    'user_code' => $info->user_code,
                    'lat' => $myArray[0],
                    'lng' => $myArray[1],
                    'position' => [
                        'lat' => (float) $myArray[0],
                        'lng' => (float) $myArray[1],
                    ],
                    'battery' => $info->current_battery_percentage,
                    'android_version' => $info->android_version,
                    'IMEI' => $info->IMEI,
                    'description' => $info->updated_at->diffForHumans(),
                ];
                array_push($initialMarkers, $array);

                // Use array_key_exists() to check if the title already exists in $markersByTitle
                if (!array_key_exists($array['title'], $markersByTitle)) {
                    $markersByTitle[$array['title']][] = $array;
                }
            }
        }

        return view('livewire.maps.agents.dashboard', [
            'initialMarkers' => $initialMarkers,
            'markersByTitle' => $markersByTitle,
        ]);
    }

    // ... (other methods)

    public function toggleCustomerList()
    {
        $this->customerListVisible = !$this->customerListVisible;
    }

    public function plotMarkers($userCode)
    {
        $information = CurrentDeviceInformation::where('user_code', $userCode)->get();
        $mapMarkers = $information->map(function ($info) {
            $myArray = explode(',', $info->current_gps);
            return [
                'lat' => (float) $myArray[0],
                'lng' => (float) $myArray[1],
            ];
        })->toArray();

        // Emit an event with the plotted markers data to update the map
        $this->emit('updateMapMarkers', $mapMarkers);
    }
}
