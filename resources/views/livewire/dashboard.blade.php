<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Livewire\Volt\{state};

state(['ideas' => function () {
    /** @var User|null $user */
    $user = Auth::user();
    return $user ? $user->ideas()->latest()->get() : [];
}]);
?>

<div class="w-full py-6">
    <div class="w-[90vw] max-w-[90vw] mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($ideas as $idea)
            <livewire:idea-card :idea="$idea" :key="$idea->id" />
        @endforeach
    </div>
</div>
