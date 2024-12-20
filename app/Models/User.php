<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'company_id',
        'is_superadmin',
        'phone',
        'profile_image',
        'address',
        'status',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // public function basicSalary()
    // {
    //     return $this->hasOne(BasicSalary::class);
    // }

    // public function payrolls()
    // {
    //     return $this->hasMany(Payroll::class);
    // }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_users');
    // }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }

    // public function designation()
    // {
    //     return $this->belongsTo(Designation::class);
    // }

    // public function shift()
    // {
    //     return $this->belongsTo(Shift::class);
    // }

    // public function hasPermission(string $permission): bool
    // {

    //     $hasPermission = $this->roles()->whereHas('permissions', function ($query) use ($permission) {
    //         $query->where('name', $permission);
    //     });


    //     Log::info($hasPermission->toSql());

    //     return $hasPermission->exists();
    // }

    // public function hasPermission(string $permission): bool
    // {
    //     return $this->role && $this->role->permissions()->where('name', $permission)->exists();
    // }


}
