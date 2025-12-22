<?php

namespace App\Livewire;

use App\Models\Tenure;
use Livewire\Component;
use Livewire\Attributes\On;

class TenuresComponent extends Component
{
    public $search = '';
    public $showForm = false;
    public $editingTenure = null;

    #[On('tenureSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingTenure = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('searchTenures')]
    public function handleSearch($search)
    {
        $this->search = $search;
    }

    #[On('openCreateTenure')]
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
        // Livewire handles reactivity
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('create-tenures')) {
            abort(403);
        }
        $this->showForm = true;
        $this->editingTenure = null;
    }

    public function openEditForm($tenureId)
    {
        if (!auth()->user()->can('edit-tenures')) {
            abort(403);
        }
        $this->editingTenure = Tenure::find($tenureId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingTenure = null;
    }

    public function deactivateTenure($tenureId)
    {
        if (!auth()->user()->can('delete-tenures')) {
            abort(403);
        }
        $tenure = Tenure::find($tenureId);
        if ($tenure) {
            $tenure->update(['active' => false]);
            session()->flash('message', 'Tenure deactivated successfully.');
        }
    }

    public function render()
    {
        $query = Tenure::active()
            ->withCount(['employees' => fn($q) => $q->where('active', true)]);
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        $tenures = $query->orderBy('name')->get();

        return view('livewire.tenures-component', [
            'tenures' => $tenures,
        ]);
    }
}
