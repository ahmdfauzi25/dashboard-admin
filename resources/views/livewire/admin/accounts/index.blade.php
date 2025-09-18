<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Akun Dijual</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Akun Dijual</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Tambah Akun</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.accounts.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga (IDR)</label>
                        <input type="number" name="price" class="form-control" min="0" step="1">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Akun</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @if(!is_null($item->price))
                                    Rp {{ number_format((int)$item->price, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">Akun Dijual</h1>

	@if (session('status'))
		<div class="bg-green-100 text-green-800 p-2 mb-4">{{ session('status') }}</div>
	@endif

	<form method="POST" action="{{ route('admin.accounts.store') }}" class="space-y-2 mb-6">
		@csrf
		<input name="title" placeholder="Judul akun" class="border p-2 w-full" required>
		<textarea name="description" placeholder="Deskripsi" class="border p-2 w-full"></textarea>
		<input name="price" placeholder="Harga (opsional)" type="number" min="0" class="border p-2 w-full">
		<label class="inline-flex items-center space-x-2">
			<input type="checkbox" name="is_active" checked>
			<span>Aktif</span>
		</label>
		<button class="bg-blue-600 text-white px-4 py-2">Simpan</button>
	</form>

	<table class="w-full border">
		<thead>
			<tr class="bg-gray-100">
				<th class="p-2 border">Judul</th>
				<th class="p-2 border">Harga</th>
				<th class="p-2 border">Aktif</th>
			</tr>
		</thead>
		<tbody>
			@foreach($accounts as $account)
			<tr>
				<td class="p-2 border">{{ $account->title }}</td>
				<td class="p-2 border">
					@if($account->price)
						Rp {{ number_format($account->price,0,',','.') }}
					@else
						-
					@endif
				</td>
				<td class="p-2 border">{{ $account->is_active ? 'Ya' : 'Tidak' }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div class="mt-4">{{ $accounts->links() }}</div>
</div>
@endsection


