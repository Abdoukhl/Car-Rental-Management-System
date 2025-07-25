<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <style>.glow-red {
        color: #ff4d4d;
        text-shadow: 0 0 5px #ff4d4d, 0 0 10px #ff1a1a, 0 0 15px #ff1a1a;
    }
    </style>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm glow-red">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
        
    </header>

    <button
    x-data
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="custom-danger-btn"
>
    <i class="fas fa-trash-alt mr-2"></i> Delete Account
</button>

<style>
.custom-danger-btn {
    background: linear-gradient(45deg, #e53935, #e35d5b);
    color: white;
    padding: 12px 24px;
    margin: 3px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.custom-danger-btn:hover {
    background: linear-gradient(45deg, #d32f2f, #ef5350);
    transform: scale(1.05);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
}
</style>


    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    x-on:click="$dispatch('close')"
                    class="custom-secondary-btn"
                >
                    Cancel
                </button>
            
                <button
                    class="custom-danger-btn"
                    x-on:click="$dispatch('open-modal', 'confirm-user-deletion')"
                >
                    Delete Account
                </button>
            </div>
            
            <style>
            .custom-secondary-btn {
                background-color: #f3f4f6;
                color: #374151;
                padding: 10px 20px;
                border: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            
            .custom-secondary-btn:hover {
                background-color: #e5e7eb;
            }
            
            .custom-danger-btn {
                background: linear-gradient(45deg, #e53935, #e35d5b);
                color: white;
                padding: 10px 24px;
                border: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            }
            
            .custom-danger-btn:hover {
                background: linear-gradient(45deg, #c62828, #ef5350);
                transform: scale(1.04);
            }
            </style>
            
        </form>
    </x-modal>
</section>