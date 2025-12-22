<?php

namespace App\Livewire;

use App\Models\Partner;
use Livewire\Component;
use Illuminate\Validation\Rule;

class PartnerForm extends Component
{
    public ?Partner $partner = null;
    
    // Company details
    public $company_name = '';
    public $company_email = '';
    public $company_phone = '';
    public $company_address = '';
    
    // Contact person details
    public $contact_person = '';
    public $contact_person_title = '';
    public $contact_email = '';
    public $contact_phone = '';
    
    // Accordion state
    public $contactPersonOpen = false;

    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_email' => [
                'required',
                'email',
                Rule::unique('partners', 'company_email')->ignore($this->partner?->id),
            ],
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ];
    }

    public function mount(?Partner $partner = null)
    {
        if ($partner) {
            $this->partner = $partner;
            $this->company_name = $partner->company_name;
            $this->company_email = $partner->company_email;
            $this->company_phone = $partner->company_phone;
            $this->company_address = $partner->company_address;
            $this->contact_person = $partner->contact_person;
            $this->contact_person_title = $partner->contact_person_title;
            $this->contact_email = $partner->contact_email;
            $this->contact_phone = $partner->contact_phone;
            
            // Open accordion if contact person exists
            $this->contactPersonOpen = !empty($partner->contact_person);
        }
    }
    
    public function toggleContactPerson()
    {
        $this->contactPersonOpen = !$this->contactPersonOpen;
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
                'company_email' => $this->company_email,
                'company_phone' => $this->company_phone,
                'company_address' => $this->company_address,
                'contact_person' => $this->contact_person,
                'contact_person_title' => $this->contact_person_title,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
            ]);
        } else {
            // Create new
            if (!auth()->user()->can('create-partners')) {
                abort(403);
            }
            Partner::create([
                'company_name' => $this->company_name,
                'company_email' => $this->company_email,
                'company_phone' => $this->company_phone,
                'company_address' => $this->company_address,
                'contact_person' => $this->contact_person,
                'contact_person_title' => $this->contact_person_title,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
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
