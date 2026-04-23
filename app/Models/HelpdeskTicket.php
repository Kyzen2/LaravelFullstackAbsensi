<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpdeskTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status', // open, in_progress, resolved, closed
        'priority', // low, medium, high
        'rating',
        'operator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function responses()
    {
        return $this->hasMany(HelpdeskResponse::class, 'ticket_id')->orderBy('created_at', 'asc');
    }
}
