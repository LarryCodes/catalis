<?php

namespace App\Livewire;

use App\Models\Partner;
use Livewire\Component;
use Illuminate\Validation\Rule;

class PartnerForm extends Component
{
    public ?Partner $partner = null;
    public $company_name = '';
    public $contact_person = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $company_address = '';

    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => [
                'required',
                'email',
                Rule::unique('partners', 'contact_email')->ignore($this->partner?->id),
            ],
            'contact_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
        ];
    }

    public function mount(?Partner $partner = null)
    {
        if ($partner) {
            $this->partner = $partner;
            $this->company_name = $partner->company_name;
            $this->contact_person = $partner->contact_person;
            $this->contact_email = $partner->contact_email;
            $this->contact_phone = $partner->contact_phone;
            $this->company_address = $partner->company_address;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->partner) {
            // Update existing
            if (!auth()->user()->can('edit-partners')) {
                abort(403);
            }
            $this->partner->update([
                'company_name' => $this->company_name,
                'contact_person' => $this->contact_person,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
                'company_address' => $this->company_address,
            ]);
        } else {
            // Create new
            if (!auth()->user()->can('create-partners')) {
                abort(403);
            }
            Partner::create([
                'company_name' => $this->company_name,
                'contact_person' => $this->contact_person,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
                'company_address' => $this->company_address,
                'active' => true,
            ]);
        }

        $message = $this->partner ? 'Partner updated successfully.' : 'Partner added successfully.';
        
        $this->dispatch('partnerSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.partner-form');
    }
}
