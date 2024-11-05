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

    public function openModal(?int $bannerId = null): void
    {
        if ($bannerId) {
            $this->form->setBanner(Banner::findOrFail($bannerId));
            $this->isEditMode = true;
        } else {
            $this->isEditMode = false;
        }
        $this->openBannerModal = true;
    }

    public function render()
    {
        return view('livewire.banners.banner-list', [
            'banners' => Banner::all(),
        ]);
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->form->update();
            session()->flash('success', 'Vendor Updated Successfully!!');
        } else {
            $this->form->store();
            session()->flash('success', 'Vendor Created Successfully!!');
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
        session()->flash('success', 'Vendor Deleted Successfully!!');
    }

}
