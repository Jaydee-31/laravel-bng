<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Banners') }}
        </h2>
    </x-slot>

    <div class="col-md-8 mb-2">
        @if(session()->has('success'))
            <x-alert>
                {{ session()->get('success') }}
            </x-alert>
        @endif
        @if(session()->has('error'))
            <x-alert>
                {{ session()->get('error') }}
            </x-alert>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-button wire:click="openModal" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-button>

            @include('livewire.banners.banner-form')

            <div class="col-md-8 mt-6">
                <div class="card">
                    <div class="overflow-hidden overflow-x-auto card-body">
                        <div class="table-responsive">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            Title
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($banners as $banner)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $banner->id }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                                {{ $banner->name }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                                {{ $banner->description }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button wire:click="openModal({{ $banner->id }})" class="text-blue-600 dark:text-blue-500 hover:text-blue-900 mr-4 ">Edit</button>
                                                <button  wire:click="delete({{ $banner->id }})"
                                                         wire:confirm="Are you sure you want to delete this record?" type="button" class="text-red-600 dark:text-red-400 hover:text-red-900 cursor-pointer mr-2"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                No banners Found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
