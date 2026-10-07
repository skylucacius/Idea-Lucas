<?php

use function Livewire\Volt\{mount};

mount(function () {
    // Se quiser que a sessão continue ativa ("lembrar de mim"):
    // Auth::login($user, remember: true);

    // Regenera a sessão para segurança (evita fixation attack)
    session()->regenerate();

    // Redireciona para a página inicial/dashboard
    return redirect()->route('dashboard');
});

?>

<div>
    <!-- Conteúdo do componente -->
</div>