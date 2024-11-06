<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class CountryList extends Component
{
    public function render()
    {
        return view('livewire.countries.country-list', [
            'countries' => Country::select('code', 'name', 'language_code')->orderby('code', 'asc')->get(),
        ]);
    }
}
