<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;

class Merchandizer extends Component
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
       $merchandizer =  User::where('account_type', ['Merchandiser'])->whereLike([
          'Region.name', 'name', 'email', 'phone_number',
       ], $searchTerm)
          ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
          ->paginate($this->perPage);
 
       return view('livewire.users.merchandizer', compact('merchandizer'));
    }
    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       return redirect()->to('/users/merchandizer');
    }
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
 
       return redirect()->to('/users/merchandizer');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();

            return redirect()->to('/users/merchandizer');
        }
    }

}
