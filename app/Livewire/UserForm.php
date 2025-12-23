<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserForm extends Component
{
    public ?User $user = null;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRoles = [];

    public function mount(?User $user = null)
    {
        $this->user = $user;
        
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->selectedRoles = $user->roles->pluck('id')->toArray();
        }
    }

    public function rules()
    {
        $userId = $this->user?->id;
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'selectedRoles' => 'array',
        ];

        if (!$this->user) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function getRolesProperty()
    {
        return Role::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->user) {
            if (!auth()->user()->can('manage-users')) {
                abort(403);
            }
            
            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];
            
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            
            $this->user->update($data);
            $this->user->syncRoles($this->selectedRoles);
            
            $message = 'User updated successfully.';
        } else {
            if (!auth()->user()->can('manage-users')) {
                abort(403);
            }
            
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            
            $user->syncRoles($this->selectedRoles);
            
            $message = 'User created successfully.';
        }

        $this->dispatch('userSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.user-form');
    }
}
