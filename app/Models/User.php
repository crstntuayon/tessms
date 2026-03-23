<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'photo',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
          'settings' => 'array',
    'two_factor_enabled' => 'boolean',
    ];

    // Default settings
public function getSettingsAttribute($value)
{
    $defaults = [
        'profile_visible' => true,
        'email_visible_to_students' => false,
        'show_last_active' => true,
    ];

    // decode JSON if $value is a string
    $value = is_string($value) ? json_decode($value, true) : $value;

    // fallback to empty array if null
    return array_merge($defaults, $value ?? []);
}
    public function role()
{
    return $this->belongsTo(Role::class);
}

public function student()
{
    return $this->hasOne(Student::class);
}

 public function sections()
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }

     public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    

}