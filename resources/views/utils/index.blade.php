@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Server Utilities</h1>
        <p class="text-sm text-gray-600">Pantau dan kelola utilitas server Anda.</p>
    </div>

    <div class="bg-white rounded-xl shadow-modern">
        <div class="border-b px-4 pt-4">
            <nav class="flex space-x-2" role="tablist">
                <button id="tab-status" data-target="#panel-status" class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-blue-50 text-blue-700" aria-selected="true">Server Status</button>
                <button id="tab-maintenance" data-target="#panel-maintenance" class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md text-gray-600 hover:text-gray-800" aria-selected="false">Maintenance Manager</button>
            </nav>
        </div>
        <div class="p-4">
            <section id="panel-status" class="tab-panel block">
                @livewire('utils.server-status')
            </section>
            <section id="panel-maintenance" class="tab-panel hidden">
                @livewire('utils.maintenance-manager')
            </section>
        </div>
    </div>

    <script>
        (function() {
            const tabs = document.querySelectorAll('.tab-btn');
            const panels = document.querySelectorAll('.tab-panel');
            function activate(targetId) {
                panels.forEach(p => p.classList.add('hidden'));
                const panel = document.querySelector(targetId);
                if (panel) panel.classList.remove('hidden');
                tabs.forEach(b => {
                    const active = b.getAttribute('data-target') === targetId;
                    b.setAttribute('aria-selected', active ? 'true' : 'false');
                    b.classList.toggle('bg-blue-50', active);
                    b.classList.toggle('text-blue-700', active);
                    b.classList.toggle('text-gray-600', !active);
                });
            }
            tabs.forEach(btn => btn.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                if (target) activate(target);
            }));
        })();
    </script>
</div>
@endsection


