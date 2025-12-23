<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingUser = null;

    #[On('userSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingUser = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('searchUsers')]
    public function handleSearch($search)
    {
        $this->search = $search;
    }

    #[On('openCreateUser')]
    public function handleOpenCreateForm()
    {
        $this->openCreateForm();
    }

    #[On('closeForm')]
    public function handleCloseForm()
    {
        $this->closeForm();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::query()
            ->with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(15);
    }

    public function getRolesProperty()
    {
        return Role::orderBy('name')->get();
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('manage-users')) {
            abort(403);
        }
        $this->showForm = true;
        $this->editingUser = null;
    }

    public function openEditForm($userId)
    {
        if (!auth()->user()->can('manage-users')) {
            abort(403);
        }
        $this->editingUser = User::find($userId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingUser = null;
    }

    public function deleteUser($userId)
    {
        if (!auth()->user()->can('manage-users')) {
            abort(403);
        }
        
        $user = User::find($userId);
        if ($user && $user->id !== auth()->id()) {
            $user->delete();
            session()->flash('message', 'User deleted successfully.');
        } else {
            session()->flash('error', 'Cannot delete your own account.');
        }
    }

    public function render()
    {
        return view('livewire.users-component');
    }
}
