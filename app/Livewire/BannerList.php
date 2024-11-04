<?php

namespace App\Livewire;

use App\Models\Banner;
use Livewire\Component;

class BannerList extends Component
{
    public function render()
    {
        return view('livewire.banner.banner-list', [
            'banners' => Banner::all(),
        ]);
    }
}
