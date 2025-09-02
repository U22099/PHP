@props(['freelancerDetails'])

<x-layout>
    <x-slot:title>
        Freelancer Profile: {{ $freelancerDetails->professional_name }}
    </x-slot:title>

    <x-slot:heading>
        Edit: {{ $freelancerDetails->professional_name }}
    </x-slot:heading>

    <x-slot:headerbutton>
        <x-button type="link" href="/profile">
            <x-heroicon-o-arrow-left class="h-5 w-5 mr-2 text-white" />
            Go Back
        </x-button>
    </x-slot:headerbutton>
    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <form method="POST" action="/profile/freelancer" class="space-y-4">
            @csrf
            @method('PATCH')
            <x-form-field class="w-full" label="Professional Name" :data="$freelancerDetails->professional_name" fieldname="professional_name"
                required>
                <x-slot:icon>
                    <x-heroicon-o-user class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('professional_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <x-form-field class="w-full" label="Professional Summary" :textarea="true" :data="$freelancerDetails->professional_summary"
                :rows="5" :characterLimit="Auth::user()->is_premium
                    ? env('PROFESSIONAL_SUMMARY_LIMIT_PER_USER_PREMIUM')
                    : env('PROFESSIONAL_SUMMARY_LIMIT_PER_USER')" fieldname="professional_summary" required>
                <x-slot:icon>
                    <x-heroicon-o-document-text class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('professional_summary')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field class="w-full" :data="$freelancerDetails->country" fieldname="country">
                    <x-slot:icon>
                        <x-heroicon-o-flag class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('country')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </x-form-field>
                <x-form-field class="w-full" :data="$freelancerDetails->city" fieldname="city">
                    <x-slot:icon>
                        <x-heroicon-o-building-office class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('city')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </x-form-field>
            </div>
            <x-form-field class="w-full" label="Phone Number (WhatsApp Only)" :data="$freelancerDetails->phone_number"
                fieldname="phone_number">
                <x-slot:icon>
                    <x-heroicon-o-phone class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <x-form-field class="w-full" label="Skills (comma-separated)" :data="'{{ json_decode($freelancerDetails->skills, true) ?? [] }}'" fieldname="skills">
                <x-slot:icon>
                    <x-heroicon-o-wrench-screwdriver class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('skills')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <x-form-field class="w-full" label="Portfolio Link" :data="$freelancerDetails->portfolio_link" fieldname="portfolio_link">
                <x-slot:icon>
                    <x-heroicon-o-globe-alt class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('portfolio_link')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <x-form-field class="w-full" label="Years of Experience" :data="$freelancerDetails->years_of_experience" fieldname="years_of_experience">
                <x-slot:icon>
                    <x-heroicon-o-briefcase class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('years_of_experience')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <x-markdown-editor class="w-full" :data="$freelancerDetails->education" fieldname="education">
                @error('education')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-markdown-editor>
            <x-markdown-editor class="w-full" :data="$freelancerDetails->certifications" fieldname="certifications">
                @error('certifications')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-markdown-editor>
            <x-form-field class="w-full" label="Languages (comma-separated)" :data="'{{ json_decode($freelancerDetails->languages, true) ?? [] }}'" fieldname="languages">
                <x-slot:icon>
                    <x-heroicon-o-language class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('languages')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <div class="w-full">
                <label for="availability" class="block text-sm font-medium leading-6 text-gray-900">Availability</label>
                <div
                    class="flex mt-2 rounded-md border-0 py-1.5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 active:ring-2 active:ring-inset active:ring-indigo-600 shadow-sm">
                    <div class="flex px-3 items-center">
                        <x-heroicon-o-clock class="h-5 w-5 text-gray-400" />
                    </div>
                    <select name="availability" id="availability"
                        class="block bg-transparent w-full sm:text-sm sm:leading-6 focus:outline-none">
                        <option value="">Select Availability</option>
                        <option value="Full-time"
                            {{ old('availability', $freelancerDetails->availability) === 'Full-time' ? 'selected' : '' }}>
                            Full-time</option>
                        <option value="Part-time"
                            {{ old('availability', $freelancerDetails->availability) === 'Part-time' ? 'selected' : '' }}>
                            Part-time</option>
                        <option value="Hourly"
                            {{ old('availability', $freelancerDetails->availability) === 'Hourly' ? 'selected' : '' }}>
                            Hourly
                        </option>
                    </select>
                </div>
                @error('availability')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full">
                <label for="response_time" class="block text-sm font-medium leading-6 text-gray-900">Response
                    Time</label>
                <div
                    class="mt-2 flex rounded-md border-0 py-1.5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 active:ring-2 active:ring-inset active:ring-indigo-600 shadow-sm">
                    <div class="flex px-3 items-center">
                        <x-heroicon-o-arrow-path class="h-5 w-5 text-gray-400" />
                    </div>
                    <select name="response_time" id="response_time"
                        class="block bg-transparent w-full sm:text-sm sm:leading-6 focus:outline-none">
                        <option value="">Select Response Time</option>
                        <option value="Within an hour"
                            {{ old('response_time', $freelancerDetails->response_time) === 'Within an hour' ? 'selected' : '' }}>
                            Within an hour</option>
                        <option value="Within a few hours"
                            {{ old('response_time', $freelancerDetails->response_time) === 'Within a few hours' ? 'selected' : '' }}>
                            Within a few hours</option>
                        <option value="Within a day"
                            {{ old('response_time', $freelancerDetails->response_time) === 'Within a day' ? 'selected' : '' }}>
                            Within a day</option>
                    </select>
                </div>
                @error('response_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <x-form-field class="w-full" label="LinkedIn Profile URL" :data="$freelancerDetails->linkedin_profile" fieldname="linkedin_profile">
                <x-slot:icon>
                    <x-heroicon-o-link class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('linkedin_profile')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </x-form-field>
            <div class="mb-4">
                <x-searchable-input name="stacks" label="Your Stacks" placeholder="Add your Stacks..."
                    :availableItems="$availableStacks" :initialItems="old('stacks', $freelancerDetails->stacks->pluck('name')->toArray())" />
                @error('stacks')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end mt-6">
                <x-button type="submit">Save Changes</x-button>
            </div>
        </form>
    </div>
</x-layout>
