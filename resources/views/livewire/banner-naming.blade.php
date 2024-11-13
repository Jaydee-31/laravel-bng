<?php

use App\Models\Banner;
use App\Models\Country;
use App\Models\Vendor;
use Livewire\Volt\Component;

new class extends Component {
    public $countries = [];
    public $vendors;
    public $banners = [];
    public $sizes = [];
    public $calendarWeek;
    public $prefix = NULL;

    public $selectedSize = NULL;
    public $selectedBanner = NULL;
    public $selectedVendor = NULL;
    public $campaign;
    public $campaign_id;
    public $output = NULL;

    public function mount(): void
    {
        $year = date("y");
        $weekNumber = date('W',);

        $this->calendarWeek = "{$year}CW{$weekNumber}";
        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
        $this->vendors = Vendor::select('name')->orderby('id', 'desc')->get();
        $this->countries = Country::select('code', 'name', 'language_code')->orderby('code', 'asc')->get();
    }

    public function updatedSelectedBanner($banner)
    {
//        dd($banner);
        $this->sizes = Banner::where('name', $banner)->value('sizes');
        $this->selectedSize = NULL;
    }


    public function generateName(): void
    {
        // Format the output as desired

        $selectedVendors = strtolower($this->selectedVendor);
        $campaign = str_replace(' ', '', ucwords($this->campaign));
        $this->output = "{$selectedVendors}_{$campaign}_{$this->campaign_id}_{$this->selectedBanner}_{$this->selectedSize}";
    }
} ?>

<div>
    <div class="p-6 mx-auto text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 dark:bg-opacity-50">
        <h2 class="text-lg font-bold mb-4">Banners & Graphics Naming Generator </h2>

        <!-- Vendors -->
        <div class="block mb-3">
            <x-label>Vendor:</x-label>
            <x-select type="text" wire:model="selectedVendor" wire:ignore class="mt-1 w-full"
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
                <x-label>Banner Name:</x-label>
                <x-select wire:model.live="selectedBanner" wire:ignore class="mt-1 w-full">
                    <option value="">Select Banner</option>
                    @foreach($banners as $banner)
                        <option value="{{ $banner->name }}">{{ $banner->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <!-- Size-->
            <div class="block mb-3">
                <x-label>Size:</x-label>
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
                <x-label>Campaign Name:</x-label>
                <x-input type="text" wire:model="campaign" class="mt-1 w-full"
                         placeholder="e.g. Promo"></x-input>
            </div>
            <!-- Campaign ID -->
            <div class="block mb-3">
                <x-label>Campaign ID:</x-label>
                <x-input type="text" wire:model="campaign_id" class="mt-1 w-full"
                         placeholder="e.g. IS200401"></x-input>
            </div>
            <!-- Calendar Week -->
            <div class="block mb-3">
                <x-label>Calendar Week:</x-label>
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
            <div class="overflow-hidden overflow-x-auto card-body">
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                        <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100 ">
                                Sales Org
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                Country Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                Language Code
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                Result
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                Copy Link
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($countries as $country)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $country->code }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                    {{ $country->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                    {{ $country->language_code }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{ $country->code }}_{{$this->selectedVendor}}_{{ $country->language_code }}{{ $output }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                    No countries Found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4 p-4 rounded">
                <h3 class="font-semibold">Generated Name:</h3>
                <p id="generatedOutput">{{ $this->output }}</p>
                <x-button id="copyButton" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded"
                          onclick="copyToClipboard()">Copy
                </x-button>
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
