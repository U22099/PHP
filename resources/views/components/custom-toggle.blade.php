@props(['fieldname', 'is_checked' => false, 'is_premium', 'label' => $fieldname, 'update_url' => null])

<div x-data="{
    is_checked: {{ $is_checked && $is_premium ? 'true' : 'false' }},
    update_url: '{{ $update_url ?? null }}',
    is_premium: {{ $is_premium ? 'true' : 'false' }},
    loading: false,
    updateStatus() {
        this.loading = true;

        if (!this.update_url) return;


        fetch(this.update_url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    is_checked: this.is_checked,
                })
            })
            .then(response => response.json())
            .then(data => {
                this.is_checked = data.job_alert;
                this.loading = false;
            })
            .catch(error => {
                console.error('Error updating status:', error);
                this.is_checked = false;
                this.loading = false;
            });
    }
}" class="w-full flex items-start">
    <label for="{{ $fieldname }}" class="flex items-center cursor-pointer w-full justify-between"
        :class="loading ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''">
        <div class="flex items-center gap-2 font-bold text-gray-900">
            @isset($icon)
                {{ $icon }}
            @endisset
            <span>{{ $label }}</span>
        </div>
        <div class="flex items-center">
            <template x-if="loading">
                <x-eva-loader-outline class="mr-2 w-5 h-5 animate-spin duration-300" />
            </template>
            <div class="relative">
                <input type="checkbox" id="{{ $fieldname }}" name="{{ $fieldname }}" class="sr-only"
                    @change="updateStatus()" :disabled="loading || !is_premium" x-model="is_checked">

                <div class="block w-10 h-6 rounded-full" :class="is_checked ? 'bg-indigo-600' : 'bg-gray-200'"></div>

                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform"
                    :class="is_checked ? 'translate-x-full' : ''"></div>
            </div>
        </div>
    </label>
</div>
