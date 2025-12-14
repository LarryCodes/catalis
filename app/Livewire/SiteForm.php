<?php

namespace App\Livewire;

use App\Models\Site;
use Livewire\Component;

class SiteForm extends Component
{
    public ?Site $site = null;
    public $partner_id;
    public $name = '';
    public $address = '';
    public $description = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function mount($site = null, $partnerId = null)
    {
        $this->partner_id = $partnerId;
        
        if ($site) {
            $this->site = $site;
            $this->partner_id = $site->partner_id;
            $this->name = $site->name;
            $this->address = $site->address ?? '';
            $this->description = $site->description ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->site) {
            if (!auth()->user()->can('edit-sites')) {
                abort(403);
            }
            $this->site->update([
                'name' => $this->name,
                'address' => $this->address,
                'description' => $this->description,
            ]);
            $message = 'Site updated successfully.';
        } else {
            if (!auth()->user()->can('create-sites')) {
                abort(403);
            }
            Site::create([
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'address' => $this->address,
                'description' => $this->description,
                'active' => true,
            ]);
            $message = 'Site added successfully.';
        }

        $this->dispatch('siteSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.site-form');
    }
}
