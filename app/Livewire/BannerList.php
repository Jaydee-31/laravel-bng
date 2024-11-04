<?php

namespace App\Livewire;

use App\Livewire\Forms\BannerForm;
use App\Models\Banner;
use Livewire\Component;

class BannerList extends Component
{
    public BannerForm $form;
    public $openBannerModal = false;

    public function openModal(): void
    {
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
        $this->form->store();

        $this->openBannerModal = false;
    }

}
