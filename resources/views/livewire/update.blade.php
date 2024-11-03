<form>
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mx-5 md:col-span-2">
            <div class="shadow overflow-hidden rounded-xl sm:rounded-xl">
                <div class="p-5 bg-white dark:bg-gray-800 dark:bg-opacity-50">

                    <input type="hidden" wire:model="category_id">
                    <div class="px-2 py-3 sm:px-5 sm:py-3">
                        <x-label for="categoryName">Name</x-label>
                        <x-input class="block mt-1 w-full" type="text" id="categoryName" placeholder="Enter Name" wire:model="name"></x-input>
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="px-2 py-3 sm:px-5 sm:py-3">
                        <x-label for="categoryDescription">Description</x-label>
                        <x-input class="block mt-1 w-full" type="text" id="categoryDescription" wire:model="description" placeholder="Enter Description"></x-input>
                        @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="flex items-center sm:justify-end justify-center px-10 py-5 bg-gray-50 dark:bg-gray-800 text-right">
                        <x-button wire:click.prevent="update()" class="ml-5">
                            Save
                        </x-button>
                        <x-button wire:click.prevent="cancel()">
                            Cancel
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>