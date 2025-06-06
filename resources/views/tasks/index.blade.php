```php
@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <!-- Kolom Tugas -->
        <div class="col-lg-8 col-12">
            <!-- Kartu Filter -->
            <div class="card p-4 mb-4">
                <h3 class="mb-3"><i class="bi bi-funnel-fill me-2"></i>Filter Tugas</h3>
                <form action="{{ route('tasks.filter') }}" method="GET">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6 col-12">
                            <select name="status" class="form-select" aria-label="Filter status">
                                <option value="">Semua Tugas</option>
                                <option value="pending">Belum Selesai</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Kartu Tambah Tugas -->
            <div class="card p-4 mb-4">
                <h3 class="mb-3"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Tugas Baru</h3>
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-5 col-12">
                            <input type="text" name="title" class="form-control" placeholder="Judul tugas" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5 col-12">
                            <textarea name="description" class="form-control" placeholder="Deskripsi tugas" rows="2"></textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg me-1"></i>Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Kartu Daftar Tugas -->
            <div class="card p-4">
                <h3 class="mb-3"><i class="bi bi-list-task me-2"></i>Daftar Tugas</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $task->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ $task->status == 'pending' ? 'Belum Selesai' : 'Selesai' }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Tombol Edit (Memicu Modal) -->
                                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- Formulir Hapus -->
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Modal Edit Tugas -->
                                <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">Edit Tugas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="title{{ $task->id }}" class="form-label">Judul</label>
                                                        <input type="text" name="title" id="title{{ $task->id }}" class="form-control" value="{{ $task->title }}" required>
                                                        @error('title')
                                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description{{ $task->id }}" class="form-label">Deskripsi</label>
                                                        <textarea name="description" id="description{{ $task->id }}" class="form-control" rows="3">{{ $task->description }}</textarea>
                                                        @error('description')
                                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status{{ $task->id }}" class="form-label">Status</label>
                                                        <select name="status" id="status{{ $task->id }}" class="form-select">
                                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Belum Selesai</option>
                                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="bi bi-info-circle me-2"></i>Belum ada tugas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kutipan -->
        <div class="col-lg-4 col-12">
            <div class="card p-4 h-100">
                <h3 class="mb-4"><i class="bi bi-quote me-2"></i>Kutipan Motivasi</h3>
                <blockquote class="blockquote mb-0">
                    <p class="fst-italic text-muted">{{ $quote['quote'] }}</p>
                    <footer class="blockquote-footer mt-2">{{ $quote['author'] }}</footer>
                </blockquote>
            </div>
        </div>
    </div>
@endsection