<?php

namespace App\Livewire;

use App\Models\Site;
use App\Models\Partner;
use Livewire\Component;
use Livewire\Attributes\On;

class SitesComponent extends Component
{
    public $search = '';
    public $selectedPartnerId = null;
    public $showForm = false;
    public $editingSite = null;

    #[On('siteSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingSite = null;
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
        // Livewire handles reactivity
    }

    public function updatedSelectedPartnerId()
    {
        // Reset form when partner changes
        $this->showForm = false;
        $this->editingSite = null;
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('create-sites')) {
            abort(403);
        }
        if (!$this->selectedPartnerId) {
            session()->flash('error', 'Please select a partner first.');
            return;
        }
        $this->showForm = true;
        $this->editingSite = null;
    }

    public function openEditForm($siteId)
    {
        if (!auth()->user()->can('edit-sites')) {
            abort(403);
        }
        $this->editingSite = Site::find($siteId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingSite = null;
    }

    public function deactivateSite($siteId)
    {
        if (!auth()->user()->can('delete-sites')) {
            abort(403);
        }
        $site = Site::find($siteId);
        if ($site) {
            $site->update(['active' => false]);
            session()->flash('message', 'Site deactivated successfully.');
        }
    }

    public function render()
    {
        $partners = Partner::active()->orderBy('company_name')->get();
        
        $sites = collect();
        if ($this->selectedPartnerId) {
            if ($this->selectedPartnerId === 'all') {
                $query = Site::with('partner')->active();
            } else {
                $query = Site::where('partner_id', $this->selectedPartnerId)->active();
            }
            
            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            }
            
            $sites = $query->orderBy('name')->get();
        }

        return view('livewire.sites-component', [
            'partners' => $partners,
            'sites' => $sites,
        ]);
    }
}
