<?php

namespace App\Livewire;

use App\Models\Tenure;
use Livewire\Component;

class TenureForm extends Component
{
    public ?Tenure $tenure = null;
    public $name = '';
    public $description = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function mount($tenure = null)
    {
        if ($tenure) {
            $this->tenure = $tenure;
            $this->name = $tenure->name;
            $this->description = $tenure->description ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->tenure) {
            if (!auth()->user()->can('edit-tenures')) {
                abort(403);
            }
            $this->tenure->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $message = 'Tenure updated successfully.';
        } else {
            if (!auth()->user()->can('create-tenures')) {
                abort(403);
            }
            Tenure::create([
                'name' => $this->name,
                'description' => $this->description,
                'active' => true,
            ]);
            $message = 'Tenure added successfully.';
        }

        $this->dispatch('tenureSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.tenure-form');
    }
}
