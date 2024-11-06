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
    public $campaign_id;
    public $output = NULL;

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
//        $this->vendors = Vendor::select('name')->orderby('id', 'desc')->get();
//        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
        $this->mount();
        $this->selectedSize = NULL;
    }

    public function generateName(): void
    {
        // Format the output as desired
        $this->mount();

        $vendor = strtolower($this->selectedVendor);
        $campaign = str_replace(' ', '', ucwords($this->campaign));

        $this->output = "{$vendor}_{$this->calendarWeek}_{$campaign}_{$this->campaign_id}_{$this->selectedBanner}_{$this->selectedSize}";
    }
} ?>

<div>
    <div class="p-6 mx-auto text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 dark:bg-opacity-50">
        <h2 class="text-lg font-bold mb-4">Banners & Graphics Naming Generator </h2>

           <!-- Vendors -->
            <div class="block mb-3">
                <x-label >Vendor:</x-label>
                <x-select type="text" wire:model="selectedVendor" class="mt-1 w-full"
                        placeholder="e.g., Summer Sale">
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Banner Name -->
                <div class="block mb-3">
                    <x-label >Banner Name:</x-label>
                    <x-select wire:model.live="selectedBanner" class="mt-1 w-full">
                        <option value="">Select Banner</option>
                        @foreach($banners as $banner)
                            <option value="{{ $banner->name }}">{{ $banner->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <!-- Size-->
                <div class="block mb-3">
                    <x-label >Size:</x-label>
                    <x-select type="text" wire:model="selectedSize" class="mt-1 w-full"
                            placeholder="e.g., Summer Sale">
                        <option value="">Select Size</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
                    </x-select>
                </div>
                <!-- Campaign -->
                <div class="block mb-3">
                    <x-label >Campaign Name:</x-label>
                    <x-input type="text" wire:model="campaign" class="mt-1 w-full"
                             placeholder="e.g. Promo"></x-input>
                </div>
                <!-- Campaign ID -->
                <div class="block mb-3">
                    <x-label >Campaign ID:</x-label>
                    <x-input type="text" wire:model="campaign_id" class="mt-1 w-full"
                             placeholder="e.g. IS200401"></x-input>
                </div>
                <!-- Calendar Week -->
                <div class="block mb-3">
                    <x-label >Calendar Week:</x-label>
                    <x-input type="text" wire:model="calendarWeek" class="mt-1 w-full"
                             placeholder="e.g. 24CW45"></x-input>
                </div>
            </div>

            <!-- Generate Button -->
            <x-button wire:click="generateName"
                class="flex self-end self-baseline mt-6"
                >
                Generate Name
            </x-button>


        <!-- Display Generated Output -->
        @if($output)
            <div class="mt-4 p-4 rounded">
                <h3 class="font-semibold">Generated Name:</h3>
                <p id="generatedOutput">{{ $output }}</p>
                <x-button id="copyButton" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded" onclick="copyToClipboard()">Copy</x-button>
            </div>
        @endif

    </div>

</div>

<script>
    function copyToClipboard() {
        const outputText = document.getElementById("generatedOutput").innerText;
        navigator.clipboard.writeText(outputText).then(() => {
            document.getElementById("copyButton").innerHTML = "Copied!";
        }).catch(err => {
            console.error("Failed to copy text: ", err);
        });
    }
</script>
