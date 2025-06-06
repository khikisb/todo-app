<?php
// Pastikan tidak ada spasi atau teks sebelum <?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    // Terapkan middleware autentikasi
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan daftar tugas dan kutipan motivasi
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        // Ambil kutipan dari API-Ninjas
        $response = Http::withHeaders([
            'X-Api-Key' => env('API_NINJAS_KEY')
        ])->get('https://api.api-ninjas.com/v1/quotes');
        
        // Ambil kutipan pertama dari array
        $quote = $response->json()[0] ?? [
            'quote' => 'Tidak ada kutipan tersedia.',
            'author' => 'Unknown'
        ];

        return view('tasks.index', compact('tasks', 'quote'));
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Buat tugas baru dengan user_id dari pengguna yang login
        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    // Perbarui tugas
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        $task->update($request->only('title', 'description', 'status'));

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Hapus tugas
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

    // Filter tugas berdasarkan status
    public function filter(Request $request)
    {
        $status = $request->query('status');
        $query = Task::where('user_id', Auth::id());

        if ($status && in_array($status, ['pending', 'completed'])) {
            $query->where('status', $status);
        }

        $tasks = $query->get();
        // Ambil kutipan dari API-Ninjas
        $response = Http::withHeaders([
            'X-Api-Key' => env('API_NINJAS_KEY')
        ])->get('https://api.api-ninjas.com/v1/quotes');
        
        // Ambil kutipan pertama dari array
        $quote = $response->json()[0] ?? [
            'quote' => 'Tidak ada kutipan tersedia.',
            'author' => 'Unknown'
        ];

        return view('tasks.index', compact('tasks', 'quote'));
    }
}