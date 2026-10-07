<?php

namespace App\Concerns;

use Livewire\Attributes\On;

trait WithIdeaFilter
{

    // Declara a propriedade reativa pública
    public string $selectedStatus = 'All';
    public string $selectedStatus2;

    #[On('filter-changed')]
    public function updateSelectedStatus(string $status): void
    {
        $this->selectedStatus = $status;
    }
    
    #[On('modal-changed')]
    public function updateSelectedStatus2(string $status): void
    {
        $this->selectedStatus2 = $status;
    }
    
}