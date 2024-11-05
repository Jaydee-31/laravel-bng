<?php

namespace App\Livewire;

use App\Livewire\Forms\BannerForm;
use App\Models\Banner;
use Livewire\Component;

class BannerList extends Component
{
    public BannerForm $form;
    public $openBannerModal = false;
    public $isEditMode = false;

    public function openModal(?Banner $banner = null): void
    {
        if ($banner) {
            $this->form->setBanner($banner);
            $this->isEditMode = true;
        } else {
            $this->isEditMode = false;
        }
        $this->openBannerModal = true;
    }

    public function render()
    {
        return view('livewire.banner.banner-list', [
            'banners' => Banner::all(),
        ]);
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->form->update();
        } else {
            $this->form->store();
        }

        $this->openBannerModal = false;
    }

    public function cancel()
    {
        $this->openBannerModal = false;
        $this->form->reset();
    }

    public function archive()
    {
        //
    }

    public function delete(?Banner $banner = null)
    {
        $banner?->delete();
    }


}
