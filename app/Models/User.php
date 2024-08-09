<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user',
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function acos(): BelongsToMany
    {
        return $this->belongsToMany(Aco::class, 'useracl')->where('user_id', auth()->id());
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'userrole');
    }
    
    public function isUserPusat()
    {
        $cabang = DB::table('cabang')->select('id')->where('namacabang', 'PUSAT')->first();
        $user = auth()->user();
        $userPusat = $this->where('cabang_id',$cabang->id)->where('id',$user->id)->first();

        if ($userPusat)  return true;
        return false;
    }
}
