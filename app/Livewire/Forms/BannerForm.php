<?php

namespace App\Livewire\Forms;

use App\Models\Banner;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BannerForm extends Form
{
    public string $name = '';
    public string $description = '';

    public function store(): void
    {
        $this->validate();
        Banner::create($this->only(['name', 'description']));

        $this->reset();

    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
        ];
    }
}

