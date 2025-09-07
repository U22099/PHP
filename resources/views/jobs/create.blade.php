<x-layout>
    <x-slot:title>
        Create New Job
    </x-slot:title>

    <x-slot:heading>
        Create Job
    </x-slot:heading>

    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <form method="POST" action="/jobs">
            @csrf

            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Create a New Job Listing</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <x-form-field rootClass="sm:col-span-5" class="w-full" fieldname="title"
                            placeholder="Software Engineer" required>
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

                        <x-form-field rootClass="sm:col-span-2" class="w-full" fieldname="min_budget"
                            label="Minimum Budget (e.g.,50000)" placeholder="50000" type="number" required>
                            <x-slot:icon>
                                <x-grommet-money class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('min_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <x-form-field rootClass="sm:col-span-2" class="w-full" fieldname="max_budget"
                            label="Maximum Budget (e.g.,80000)" placeholder="80000" type="number" required>
                            <x-slot:icon>
                                <x-grommet-money class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('max_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <x-form-field rootClass="sm:col-span-2" fieldname="time_budget" label="Time Budget (in days)"
                            placeholder="7" type="number" required>
                            <x-slot:icon>
                                <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                            </x-slot:icon>
                            @error('time_budget')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <div class="col-span-full">
                            <x-form-field rootClass="sm:col-span-2" fieldname="description" label="Job Description"
                                :textarea="true" :rows="8" :characterLimit="Auth::user()->is_premium
                                    ? env('JOB_DESCRIPTION_LIMIT_PER_USER_PREMIUM')
                                    : env('JOB_DESCRIPTION_LIMIT_PER_USER')"
                                placeholder="Write a few sentences about the job requirements and responsibilities."
                                required>
                                <x-slot:icon>
                                    <x-heroicon-o-document-text class="h-5 w-5 text-gray-400" />
                                </x-slot:icon>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </x-form-field>
                        </div>

                        <div class="col-span-full">
                            <x-searchable-input name="tags" label="Jobs Tags" placeholder="Add Job Tags..."
                                :initialItems="old('tags', [])" :availableItems="$availableTags" />
                            @error('tags')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-full">
                            <x-multi-image-upload label="Add Images" name="images" :initialUrls="old('images')" :initialPublicIds="old('publicIds')"
                                :isPremium="Auth::user()->is_premium">
                                <div>
                                    @error('images')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    @error('publicIds')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    @error('images.*')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    @error('publicIds.*')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </x-multi-image-upload>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-button type="link" href="/jobs"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</x-button>
                <x-button type="submit">Create</x-button>
            </div>
        </form>
    </div>
</x-layout>
