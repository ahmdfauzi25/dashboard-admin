@extends('layouts.app')

@section('content')
<div class="p-6">
  @if (session('status'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
      <h2 class="font-bold mb-3">Tambah Banner</h2>
      <form method="POST" action="{{ route('admin.promos.store') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="section" value="banner" />
        <div>
          <label class="block text-sm">Judul (opsional)</label>
          <input name="title" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm">Image URL</label>
          <input name="image_url" class="w-full border rounded p-2" required />
        </div>
        <div>
          <label class="block text-sm">Link URL (opsional)</label>
          <input name="link_url" class="w-full border rounded p-2" />
        </div>
        <div class="flex gap-3">
          <div class="flex-1">
            <label class="block text-sm">Posisi</label>
            <input name="position" type="number" value="0" class="w-full border rounded p-2" />
          </div>
          <div class="flex items-end">
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" checked /> Aktif</label>
          </div>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Banner</button>
      </form>

      <h3 class="mt-6 font-semibold">Daftar Banner</h3>
      <ul class="mt-2 space-y-2">
        @foreach ($banners as $b)
          <li class="flex items-center gap-3 p-2 border rounded">
            <img src="{{ $b->image_url }}" class="w-20 h-12 object-cover rounded"/>
            <div class="text-sm">{{ $b->title }} <span class="text-gray-500">(#{{ $b->position }})</span></div>
          </li>
        @endforeach
      </ul>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
      <h2 class="font-bold mb-3">Flash Sale</h2>
      <form method="POST" action="{{ route('admin.promos.store') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="section" value="flashsale" />
        <div>
          <label class="block text-sm">Berakhir Pada</label>
          <input name="ends_at" type="datetime-local" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" checked /> Aktif</label>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Flash Sale</button>
      </form>

      @if ($flashsale)
        <div class="mt-3 text-sm text-gray-600">Flash sale aktif: {{ $flashsale->ends_at }}</div>
      @endif
    </div>
  </div>
</div>
@endsection


