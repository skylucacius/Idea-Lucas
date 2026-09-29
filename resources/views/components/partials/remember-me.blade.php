@props([
    'text' => __('Already registered?'),
    'linkText' => __('Log in'),
    'route' => route('login'),
])

<p class="space-x-1 rtl:space-x-reverse text-center text-sm opacity-70">
    <span>{{ $text }}</span>
    <flux:link :href="$route" wire:navigate>{{ $linkText }}</flux:link>
</p>
