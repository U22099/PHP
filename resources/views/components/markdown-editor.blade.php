@props(['fieldname', 'label' => $fieldname, 'data' => null, 'rootClass' => 'flex flex-col w-full'])

<style>
    [contenteditable] ul,
    ol {
        padding-left: 16px;
    }

    [contenteditable] ul {
        list-style-type: disc;
    }

    [contenteditable] ol {
        list-style-type: decimal;
    }

    [contenteditable] a {
        color: #4f39f6;
        cursor: pointer
    }

    @media(max-width: 769px) {

        [contenteditable] ul,
        ol {
            padding-left: 24px;
        }
    }
</style>

<div class="{{ $rootClass }}">
    <label for="{{ $fieldname }}"
        class="block text-sm font-medium leading-6 text-gray-900 capitalize">{{ $label }}</label>
    <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600"
        x-data="{
            content: '',
            formatText(command, value = null) {
                document.execCommand(command, false, value);
                this.$nextTick(() => {
                    this.content = this.$refs.editor.innerHTML.replace(/\x22/g, `'`);
                });
            },
            updateContent() {
                this.content = this.$refs.editor.innerHTML.replace(/\x22/g, `'`);
            },
            init(data) {
                this.content = data;
                $refs.editor.innerHTML = data;
            }
        }" x-init="init(`{!! old($fieldname) ?? ($data ?? '') !!}`)">

        <input type="hidden" name="{{ $fieldname }}" x-model="content">

        {{-- Toolbar --}}
        <div class="w-full bg-gray-100 border-b border-gray-300 p-2 flex flex-wrap gap-2">
            {{-- Bold Button --}}
            <button type="button" @click="formatText('bold')" class="p-1 rounded hover:bg-gray-200" title="Bold">
                <x-heroicon-s-bold class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Italic Button --}}
            <button type="button" @click="formatText('italic')" class="p-1 rounded hover:bg-gray-200" title="Italic">
                <x-heroicon-s-italic class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Underline Button --}}
            <button type="button" @click="formatText('underline')" class="p-1 rounded hover:bg-gray-200"
                title="Underline">
                <x-heroicon-s-underline class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Strikethrough Button --}}
            <button type="button" @click="formatText('strikeThrough')" class="p-1 rounded hover:bg-gray-200"
                title="Strikethrough">
                <x-heroicon-s-strikethrough class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Ordered List --}}
            <button type="button" @click="formatText('insertOrderedList')" class="p-1 rounded hover:bg-gray-200"
                title="Ordered List">
                <x-ri-list-ordered-2 class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Unordered List --}}
            <button type="button" @click="formatText('insertUnorderedList')" class="p-1 rounded hover:bg-gray-200"
                title="Unordered List">
                <x-heroicon-s-list-bullet class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Link Button --}}
            <button type="button" @click="formatText('createLink', prompt('Enter URL:'))"
                class="p-1 rounded hover:bg-gray-200" title="Insert Link">
                <x-heroicon-s-link class="h-5 w-5 text-gray-700" />
            </button>
            {{-- Unlink Button --}}
            <button type="button" @click="formatText('unlink')" class="p-1 rounded hover:bg-gray-200" title="Unlink">
                <x-heroicon-s-link-slash class="h-5 w-5 text-gray-700" />
            </button>
        </div>

        {{-- Editable Area --}}
        <div contenteditable="true" x-ref="editor" @input="updateContent()"
            {{ $attributes->merge(['class' => 'prose max-w-none p-2 outline-none min-h-[100px] list-auto']) }}>
        </div>
    </div>
    {{ $slot }}
</div>
