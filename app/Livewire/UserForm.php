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
    public $selectedRoles = null;

    public function mount(?User $user = null)
    {
        $this->user = $user;
        
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->selectedRoles = $user->roles->first()?->id;
        }
    }

    public function rules()
    {
        $userId = $this->user?->id;
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'selectedRoles' => 'required|exists:roles,id',
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

        if (!auth()->user()->can('manage-users')) {
            abort(403);
        }

        \DB::beginTransaction();
        
        try {
            if ($this->user) {
                // Update existing user
                $data = [
                    'name' => $this->name,
                    'email' => $this->email,
                ];
                
                if ($this->password) {
                    $data['password'] = Hash::make($this->password);
                }
                
                $this->user->update($data);
                $this->user->syncRoles([Role::find($this->selectedRoles)]);
                
                $message = 'User updated successfully.';
            } else {
                // Create new user
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
                
                $user->syncRoles([Role::find($this->selectedRoles)]);
                
                $message = 'User created successfully.';
            }

            \DB::commit();
            
            $this->dispatch('userSaved', message: $message);
            $this->dispatch('closeForm');
            
        } catch (\Exception $e) {
            \DB::rollBack();
            
            // If it's a validation error, re-throw it
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                throw $e;
            }
            
            // For other errors, show a generic message
            session()->flash('error', 'Failed to save user. Please try again.');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.user-form');
    }
}
