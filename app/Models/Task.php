<?php
// Pastikan tidak ada spasi atau teks sebelum <?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi
    protected $fillable = ['user_id', 'title', 'description', 'status'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}