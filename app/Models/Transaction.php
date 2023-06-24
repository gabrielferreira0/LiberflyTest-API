<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';


    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'category',
        'type',
        'price',
        'updated_at',
        'created_at',
        'user_id'
    ];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'id', 'user_id');
    }
}
