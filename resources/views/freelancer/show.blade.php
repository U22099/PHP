@props(['freelancerDetails'])

<x-layout>
    <x-slot:title>
        Freelancer Profile: {{ $freelancerDetails->professional_name }}
    </x-slot:title>

    <x-slot:heading>
        {{ $freelancerDetails->professional_name }}
    </x-slot:heading>

    <x-slot:headerbutton>
        <x-button type="link"
            href="{{ Auth::user()->id === $freelancerDetails->user_id ? '/profile' : '/' . $freelancerDetails->user->username }}">
            <x-heroicon-o-arrow-left class="h-5 w-5 mr-2 text-white" />
            Go Back
        </x-button>
    </x-slot:headerbutton>
    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl leading-6 font-bold text-gray-600">
                Freelancer Details
            </h3>
            @if (Auth::user()->id === $freelancerDetails->user_id)
                <x-button type="link" href="/profile/freelancer/edit">
                    Edit
                </x-button>
            @endif
        </div>
        <div class="border-t border-gray-200 pt-4">
            <dl class="grid grid-cols-1 gap-x-2 gap-y-4 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Professional Name
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->professional_name ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Years of Experience
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->years_of_experience ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xl font-bold text-gray-900">
                        Professional Summary
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->professional_summary ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Country
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->country ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        City
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->city ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Phone Number (WhatsApp Only)
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->phone_number ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Availability
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ $freelancerDetails->availability ?? 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Skills
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ implode(', ', json_decode($freelancerDetails->skills, true) ?? []) ?: 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Languages
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {{ implode(', ', json_decode($freelancerDetails->languages, true) ?? []) ?: 'N/A' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Education
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {!! $freelancerDetails->education ?? 'N/A' !!}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-xl font-bold text-gray-900">
                        Certifications
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        {!! $freelancerDetails->certifications ?? 'N/A' !!}
                    </dd>
                </div>
                @if ($freelancerDetails->stacks)
                    <div class="sm:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Stacks:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($freelancerDetails->stacks as $stack)
                                <span
                                    class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">{{ $stack->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="sm:col-span-2">
                    <dt class="text-xl font-bold text-gray-900">
                        Portfolio Link
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        @if ($freelancerDetails->portfolio_link)
                            <a href="{{ $freelancerDetails->portfolio_link }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-900">{{ $freelancerDetails->portfolio_link }}</a>
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xl font-bold text-gray-900">
                        LinkedIn Profile
                    </dt>
                    <dd class="mt-1 text-gray-600 break-all text-wrap">
                        @if ($freelancerDetails->linkedin_profile)
                            <a href="{{ $freelancerDetails->linkedin_profile }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-900">{{ $freelancerDetails->linkedin_profile }}</a>
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-layout>
