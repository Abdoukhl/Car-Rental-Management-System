<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // تأكد من وجود هذا الاستيراد

class ProfilePhotoUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $uploadProgress = 0;
    public $isUploading = false;
    public $previewUrl = '';

    protected $listeners = ['openProfilePhotoUpload' => 'resetForm'];

    public function mount()
    {
        $this->previewUrl = Auth::user()->profile_photo_url ?? '';
    }

    public function updatedPhoto()
    {
        $this->validate(['photo' => 'image|max:2048']);
        $this->previewUrl = $this->photo->temporaryUrl();
    }

    public function save()
    {
        $this->validate(['photo' => 'required|image|max:2048']);

        $this->isUploading = true;
        $this->uploadProgress = 10;

        /** @var User $user */
        $user = Auth::user();
        
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $this->photo->store('profile-photos', 'public');
        $this->uploadProgress = 70;

        $user->profile_photo_path = $path;
        $user->save(); // لن تظهر المشكلة الآن

        $this->uploadProgress = 100;
        $this->isUploading = false;
        
        $this->emit('profilePhotoUpdated', asset('storage/'.$path));
    }

    public function render()
    {
        return view('livewire.profile-photo-upload');
    }
}