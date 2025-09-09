<?php

namespace App\Livewire\Utils;

use App\Domains\User\LoginActivity;
use Livewire\Component;
use Livewire\WithPagination;

class SessionHistory extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $event = '';

    protected $queryString = ['search' => ['except' => ''], 'event' => ['except' => '']];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingEvent(): void { $this->resetPage(); }

    public function render()
    {
        $query = LoginActivity::query()
            ->with('user')
            ->orderByDesc('created_at');

        if ($this->search !== '') {
            $q = '%' . str_replace('%', '\\%', $this->search) . '%';
            $query->whereHas('user', function ($sub) use ($q) {
                $sub->where('name', 'like', $q)->orWhere('email', 'like', $q);
            });
        }

        if ($this->event !== '') {
            $query->where('event', $this->event);
        }

        return view('livewire.utils.session-history', [
            'activities' => $query->paginate($this->perPage),
        ]);
    }
}


