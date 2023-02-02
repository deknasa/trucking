<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    public function acos(): BelongsToMany
    {
        return $this->belongsToMany(Aco::class, 'useracl')->where('user_id', auth()->id());
    }
}
