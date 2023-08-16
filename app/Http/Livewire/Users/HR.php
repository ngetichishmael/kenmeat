<?php

namespace App\Http\Livewire\Users;


use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;
use Livewire\Component;

class HR extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
 
    public function render()
    {
       $searchTerm = '%' . $this->search . '%';
       $hr =  User::where('account_type', ['HR'])->whereLike([
          'Region.name', 'name', 'email', 'phone_number',
       ], $searchTerm)
          ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
          ->paginate($this->perPage);
 
       return view('livewire.users.h-r', compact('hr'));
    }
    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       return redirect()->to('/users/hr');
    }
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
 
       return redirect()->to('/users/hr');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();

            return redirect()->to('/users/hr');
        }
    }

}
