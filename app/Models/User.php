<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'birth_date',
        'gender_id',
        'address',
        'contact_number',
        'email',
        'username',
        'role',
        'photo',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(function () {
            if (empty($this->middle_name)) {
                return trim("{$this->first_name} {$this->last_name}");
            }

            return trim("{$this->first_name} ".substr($this->middle_name, 0, 1).". {$this->last_name}");
        });
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    /** @deprecated Use gender() */
    public function genders()
    {
        return $this->gender();
    }
}
