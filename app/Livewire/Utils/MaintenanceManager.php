<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MaintenanceManager extends Component
{
    #[Validate('nullable|string|max:255')]
    public ?string $message = null;

    /** @var array<int,string> */
    public array $selectedRouteNames = [];

    /** @var array<int,string> */
    public array $selectedUriPatterns = [];

    /** @return array<int, array{name:string,uri:string}> */
    public function getAllNamedRoutes(): array
    {
        $routes = [];
        foreach (Route::getRoutes() as $route) {
            $name = $route->getName();
            if ($name) {
                $routes[] = [
                    'name' => $name,
                    'uri' => implode('|', $route->methods()) . ' ' . $route->uri(),
                ];
            }
        }
        sort($routes);
        return $routes;
    }

    public function mount(): void
    {
        $this->message = Cache::get('maintenance.message');
        $this->selectedRouteNames = Cache::get('maintenance.routes', []);
        $this->selectedUriPatterns = Cache::get('maintenance.uris', []);
    }

    public function save(): void
    {
        Cache::forever('maintenance.message', $this->message);
        Cache::forever('maintenance.routes', array_values(array_filter(array_unique($this->selectedRouteNames))));
        Cache::forever('maintenance.uris', array_values(array_filter(array_unique($this->selectedUriPatterns))));

        $this->dispatch('show-toast', type: 'success', title: 'Maintenance settings saved');
    }

    public function clear(): void
    {
        Cache::forget('maintenance.message');
        Cache::forget('maintenance.routes');
        Cache::forget('maintenance.uris');
        $this->mount();
        $this->dispatch('show-toast', type: 'success', title: 'Maintenance cleared');
    }

    public function render()
    {
        return view('livewire.utils.maintenance-manager', [
            'routes' => $this->getAllNamedRoutes(),
        ]);
    }
}


