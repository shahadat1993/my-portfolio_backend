<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['sent' => 'boolean']; }
    public function user() { return $this->belongsTo(User::class); }
}
