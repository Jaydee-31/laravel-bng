<?php

namespace App\Livewire\Forms;

use App\Models\Banner;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BannerForm extends Form
{
    public ?Banner $banner;
    public $name = '';
    public $description = '';

    public function setBanner(Banner $banner)
    {
        $this->banner = $banner;
        $this->name = $banner->name;
        $this->description = $banner->description;
    }
    public function store(): void
    {
        $this->validate();
        Banner::create($this->only(['name', 'description']));

        $this->reset();

    }
    public function update()
    {
        $this->validate();
        $this->banner->update($this->only(['name', 'description']));

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

