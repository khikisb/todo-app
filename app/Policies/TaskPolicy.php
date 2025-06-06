<?php
// Pastikan tidak ada spasi atau teks sebelum <?php
namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// Kebijakan untuk otorisasi tugas
class TaskPolicy
{
    use HandlesAuthorization;

    // Izinkan pembaruan hanya oleh pemilik tugas
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    // Izinkan penghapusan hanya oleh pemilik tugas
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}