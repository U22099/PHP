<x-layout>
    <x-slot:title>
        Edit Job: {{ $job->title }}
    </x-slot:title>

    <x-slot:heading>
        Edit Job
    </x-slot:heading>

    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <form method="POST" action="/jobs/{{ $job->id }}">
            @csrf
            @method('PUT')

            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Edit {{ $job->title }}</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <x-form-field rootClass="sm:col-span-5" class="w-full" fieldname="title"
                            placeholder="Software Engineer" data="{{ $job->title }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <div class="sm:col-span-2">
                            <x-currency-select />
                            @error('currency_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form-field rootClass="sm:col-span-2" fieldname="min_budget"
                            label="Minimum Budget (e.g.,
                            50000)" type="number"
                            placeholder="50000" data="{{ $job->min_budget }}" required>
                            <x-slot:icon>
                                <x-grommet-money class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('min_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <x-form-field rootClass="sm:col-span-2" fieldname="max_budget"
                            label="Maximum Budget (e.g.,
                            50000)" placeholder="50000"
                            type="number" data="{{ $job->max_budget }}" required>
                            <x-slot:icon>
                                <x-grommet-money class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('max_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <x-form-field rootClass="sm:col-span-2" fieldname="time_budget" label="Time Budget (in days)"
                            placeholder="7" type="number" data="{{ $job->time_budget }}" required>
                            <x-slot:icon>
                                <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('time_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <div class="col-span-full">
                            <label for="description"
                                class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="4"
                                    class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    required>{{ old('description') ?? $job->description }}</textarea>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the job
                                requirements
                                and responsibilities.</p>
                            @error('description')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-full">
                            <x-searchable-input name="tags" label="Articles Tags" :initialItems="old('tags', $job->tags->pluck('name')->toArray())" :availableItems="$availableTags"
                                placeholder="Add tags" />
                            @error('tags')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between px-2 w-full">
                <x-button type="button" form="delete-form"
                    class="text-sm font-semibold leading-6 bg-red-600">Delete</x-button>
                <div class="flex items-center justify-end gap-x-6">
                    <x-button type="link" href="/jobs/{{ $job->id }}"
                        class="text-sm font-semibold leading-6">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </div>
        </form>
        <form method="POST" action="/jobs/{{ $job->id }}" id="delete-form" hidden>
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-layout>
