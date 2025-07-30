@props(['freelancerDetails'])

<a href="/profile/freelancer" class="block bg-white overflow-hidden rounded-lg cursor-pointer">
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-4">
            <h3 class="text-2xl leading-6 font-bold text-gray-600">
                {{ $freelancerDetails->professional_name ?? 'N/A' }}
            </h3>
        </div>
        <div class="border-t border-gray-200 pt-4">
            <div class="sm:col-span-2">
                <dt class="text-xl font-bold text-gray-900">
                    Professional Summary
                </dt>
                <dd class="mt-1 text-gray-600 line-clamp-4">
                    {{ $freelancerDetails->professional_summary ?? 'N/A' }}
                </dd>
            </div>
        </div>
    </div>
</a>