@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Page Maintenance</h1>
        <p class="text-sm text-gray-600">Kelola halaman yang ingin dimasukkan ke mode maintenance.</p>
    </div>

    @livewire('utils.maintenance-manager')
</div>
@endsection


