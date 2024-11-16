<?php

use App\Models\Banner;
use App\Models\Country;
use App\Models\Vendor;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $countries = [];
    public $vendors = [];
    public $banners = [];
    public $sizes = [];
    public $prefix = NULL;

    #[Validate('required', message: 'Please select at least one vendor.')]
    public $selectedVendors = [];
    public $selectedVendor = NULL;
    public $selectedSize = NULL;
    public $selectedBanner = NULL;
    public $campaign;
    public $campaign_id;
    public $calendarWeek;
    public $output = NULL;

    public function mount()
    {
        $year = date("y");
        $weekNumber = date('W',);

        $this->calendarWeek = "{$year}CW{$weekNumber}";
        $this->countries = Country::select('id', 'code', 'name', 'language_code')->orderby('id', 'asc')->get();
        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
        $this->vendors = Vendor::select('name')->orderby('id', 'desc')->get();
    }

    public function updatedSelectedBanner($banner)
    {
        $this->sizes = Banner::where('name', $banner)->value('sizes');
        $this->selectedSize = NULL;
    }


    public function generateName()
    {
        $this->validate();

        $this->selectedVendor = implode('&', array_map('strtolower', $this->selectedVendors));
        $campaign = str_replace(' ', '', ucwords($this->campaign));
        $campaignId = str_replace(' ', '', ucwords($this->campaign_id));
        $this->output = "{$campaign}_{$campaignId}_{$this->selectedBanner}_{$this->selectedSize}";
    }

    public function rules()
    {
        return [
            'selectedVendors' => 'required',
            'selectedBanner' => 'required',
            'selectedSize' => 'required',
            'campaign' => 'required',
            'campaign_id' => 'required',
            'calendarWeek' => ['required', 'regex:/^\d{2}CW\d{2}$/'],
        ];
    }

    public function messages()
    {
        return [
            'calendarWeek.regex' => 'The :attribute must be in the format YYCWXX where YY = Year and XX = Week. Both numbers.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'selectedVendors' => 'vendors',
            'selectedBanner' => 'banner',
            'selectedSize' => 'size',
            'campaign' => 'campaign',
            'campaign_id' => 'campaign ID',
            'calendarWeek' => 'calendar week',
        ];
    }
} ?>

<div>
    <form wire:submit="generateName">
        <div
            class="p-6 flex flex-col text-gray-900 sm:rounded-lg dark:text-gray-100 bg-white dark:bg-neutral-900 dark:bg-opacity-90 mb-6">
            <!-- Vendors -->
            <div class="block mb-6">
                <x-label>Vendor:</x-label>
                <x-select type="text" wire:model="selectedVendors" wire:ignore class="mt-1 w-full"
                          placeholder="e.g., Summer Sale"
                          multiple="">
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="selectedVendors" class="mt-2"/>
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
                    <x-input-error for="selectedBanner" class="mt-2"/>
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
                    <x-input-error for="selectedSize" class="mt-2"/>
                </div>
                <!-- Campaign -->
                <div class="block mb-3">
                    <x-label>Campaign Name:</x-label>
                    <x-input type="text" wire:model="campaign" class="mt-1 w-full"
                             placeholder="e.g. Promo"></x-input>
                    <x-input-error for="campaign" class="mt-2"/>
                </div>
                <!-- Campaign ID -->
                <div class="block mb-3">
                    <x-label>Campaign ID:</x-label>
                    <x-input type="text" wire:model="campaign_id" class="mt-1 w-full"
                             placeholder="e.g. IS200401"></x-input>
                    <x-input-error for="campaign_id" class="mt-2"/>
                </div>
                <!-- Calendar Week -->
                <div class="block mb-3">
                    <x-label>Calendar Week:</x-label>
                    <x-input type="text" wire:model="calendarWeek" class="mt-1 w-full"
                             placeholder="e.g. 24CW45"></x-input>
                    <x-input-error for="calendarWeek" class="mt-2"/>
                </div>
            </div>

            <!-- Generate Button -->
            <x-button wire:click="generateName" class="self-center mt-6">
                Generate Name
            </x-button>
        </div>
    </form>

    <!-- Display Generated Output -->
    @if($output)
        <div class="">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 dark:bg-opacity-50">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Sales Org
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Country Name
                        </th>
                        <th scope="col" class="px-6 py-3 w-1">
                            Language Code
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Result
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Copy Link
                        </th>
                    </tr>
                    </thead>

                    <tbody class="">
                    @forelse($countries as $country)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ $country->code }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $country->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $country->language_code }}
                            </td>
                            <td class="px-6 py-4">
                                <p id="generatedOutput{{$country->id}}">{{ $country->code }}_{{$this->selectedVendor}}
                                    _{{ $country->language_code }}{{ $output }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <x-button id="copyButton{{$country->id}}"
                                          class="px-4 py-2 bg-blue-500 text-white rounded"
                                          onclick="copyToClipboard({{$country->id}})">Copy
                                </x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                No countries found.
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<script>
    function copyToClipboard(id) {
        console.log(id); // Logs the actual id
        const outputText = document.getElementById(`generatedOutput${id}`).innerText;
        navigator.clipboard.writeText(outputText).then(() => {
            const copyButton = document.getElementById(`copyButton${id}`);
            copyButton.innerHTML = "Copied!";
            setTimeout(() => {
                copyButton.innerHTML = "Copy";
            }, 2000); // 1 second
        }).catch(err => {
            console.error("Failed to copy text: ", err);
        });
    }
</script>
