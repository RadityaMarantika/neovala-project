@props(['title', 'value', 'color' => 'gray', 'icon' => '📦'])

<div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-{{ $color }}-600 mt-1">{{ $value }}</p>
        </div>
        <div class="text-3xl">{{ $icon }}</div>
    </div>
</div>
