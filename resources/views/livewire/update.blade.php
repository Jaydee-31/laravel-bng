
 <x-dialog-modal wire:model.live="openingModal">

    <x-slot name="title">
        Update Vendor
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="">
                    <div class="overflow-hidden">
                        <div class="pt-5 bg-white dark:bg-gray-800 dark:bg-opacity-50">
                            <div class=" py-3 sm:py-3">
                                <x-label for="vendorName">Name</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="name" placeholder="Enter Name"/>
                                <x-input-error for="title" class="mt-1" />
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                             <div class=" py-3 sm:py-3">
                                <x-label for="vendorDescription">Description</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="description" placeholder="Enter Description"></x-input>
                                @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click.prevent="cancel()" wire:click="$toggle('openingModal')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>
        <x-button wire:click.prevent="update()" class="ms-3">
                {{ __('Save') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
