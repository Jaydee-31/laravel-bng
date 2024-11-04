
<x-dialog-modal wire:model.live="openBannerModal">

    <x-slot name="title">
        {{ $isEditMode ? 'Edit Banner' : 'Add Banner' }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="">
                    <div class="overflow-hidden">
                        <div class="pt-5 bg-white dark:bg-gray-800 dark:bg-opacity-50">

                            <div class=" py-3 sm:py-3">
                                <x-label for="vendorName">Name</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.name" placeholder="Enter Name" autofocus/>
                                <x-input-error for="title" class="mt-1" />
                                <x-input-error for="form.name" class="mt-2" />
                            </div>

                            <div class=" py-3 sm:py-3">
                                <x-label for="vendorDescription">Description</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.description" placeholder="Enter Description"></x-input>
                                <x-input-error for="form.description" class="mt-2" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click.prevent="cancel()" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>
        <x-button wire:click.prevent="save()" class="ms-3">
            {{ $isEditMode ? 'Update' : 'Save' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
