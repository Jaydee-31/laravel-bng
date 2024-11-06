<?php

use App\Models\Banner;
use App\Models\Vendor;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $vendors = [];
    public $banners = [];
    public $sizes = [];
    public $calendarWeek;

    public $selectedSize = NULL;
    public $selectedBanner = NULL;
    public $selectedVendor = NULL;
    public $campaign;
    public $id;
    public $output;

    public function mount()
    {

        $year = date("y");
        $weekNumber = date('W',);

        $this->calendarWeek = "{$year}CW{$weekNumber}";
        $this->vendors = Vendor::select('name')->orderby('id', 'desc')->get();
        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
    }

    public function updatedSelectedBanner($banner)
    {
        $this->sizes = Banner::where('name', $banner)->first()->sizes;
        $this->vendors = Vendor::select('name')->orderby('id', 'desc')->get();
        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
        $this->selectedSize = NULL;
    }

    public function generateName(): void
    {
        // Format the output as desired
        $this->mount();
//        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();

        $vendor = strtolower($this->selectedVendor);
        $campaign = str_replace(' ', '', ucwords($this->campaign));

        $this->output = "{$vendor}_{$this->calendarWeek}_{$campaign}_{$this->selectedBanner}_{$this->selectedSize}";
    }
} ?>

<div>
    <div class="p-6 max-w-md mx-auto bg-white rounded shadow">
        <h2 class="text-lg font-bold mb-4">Banner Naming Convention Generator</h2>

        <form wire:submit.prevent="generateName">
            <!-- Vendors -->
            <label class="block mb-2">
                <span class="text-gray-700">Vendor:</span>
                <select type="text" wire:model="selectedVendor" class="mt-1 block w-full border-gray-300 rounded"
                        placeholder="e.g., Summer Sale">
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </label>
            <!-- Banner Name -->
            <label class="block mb-2">
                <span class="text-gray-700">Banner Name:</span>
                <select wire:model.live="selectedBanner" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="">Select Banner</option>
                    @foreach($banners as $banner)
                        <option value="{{ $banner->name }}">{{ $banner->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mb-2">
                <span class="text-gray-700">Size:</span>
                <select type="text" wire:model="selectedSize" class="mt-1 block w-full border-gray-300 rounded"
                        placeholder="e.g., Summer Sale">
                    <option value="">Select Size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </label>

            <!-- Campaign -->
            <label class="block mb-2">
                <span class="text-gray-700">Campaign Name:</span>
                <input type="text" wire:model="campaign" class="mt-1 block w-full border-gray-300 rounded"
                       placeholder="e.g. Promo">
            </label>

            <!-- Campaign ID -->
            <label class="block mb-2">
                <span class="text-gray-700">Campaign ID:</span>
                <input type="text" wire:model="id" class="mt-1 block w-full border-gray-300 rounded"
                       placeholder="e.g. IS200401">
            </label>

            <!-- Calendar Week -->
            <label class="block mb-2">
                <span class="text-gray-700">Calendar Week:</span>
                <input type="text" wire:model="calendarWeek" class="mt-1 block w-full border-gray-300 rounded"
                       placeholder="e.g. IS200401">
            </label>


            <!-- Generate Button -->
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 dark:text-white rounded">Generate Name</button>
        </form>

        <!-- Display Generated Output -->
        @if($output)
            <div class="mt-4 p-4 bg-gray-100 rounded">
                <h3 class="text-gray-700 font-semibold">Generated Name:</h3>
                <p class="text-gray-900">{{ $output }}</p>
            </div>
        @endif
    </div>

</div>
