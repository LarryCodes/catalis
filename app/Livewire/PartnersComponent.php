<?php

namespace App\Livewire;

use App\Models\Partner;
use Livewire\Component;
use Livewire\Attributes\On;

class PartnersComponent extends Component
{
    public $search = '';
    public $showForm = false;
    public $editingPartner = null;

    #[On('partnerSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingPartner = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('closeForm')]
    public function handleCloseForm()
    {
        $this->closeForm();
    }

    public function updatedSearch()
    {
        // Live search with debouncing
    }

    public function getPartnersProperty()
    {
        return Partner::active()
            ->withCount(['employees' => function ($query) {
                $query->where('active', true);
            }])
            ->when($this->search, function ($query) {
                $query->where('company_name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                      ->orWhere('contact_email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('company_name')
            ->get();
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('create-partners')) {
            abort(403);
        }
        $this->showForm = true;
        $this->editingPartner = null;
    }

    public function openEditForm($partnerId)
    {
        if (!auth()->user()->can('edit-partners')) {
            abort(403);
        }
        $partner = Partner::find($partnerId);
        if ($partner) {
            $this->editingPartner = $partner;
            $this->showForm = true;
        }
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingPartner = null;
    }

    public function deactivatePartner($partnerId)
    {
        if (!auth()->user()->can('delete-partners')) {
            abort(403);
        }
        $partner = Partner::find($partnerId);
        if ($partner) {
            $partner->update(['active' => false]);
            session()->flash('message', 'Partner deactivated successfully.');
        }
    }

    public function render()
    {
        return view('livewire.partners-component');
    }
}
