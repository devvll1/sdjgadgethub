<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory,Notifiable;
    protected $table ='users';
    protected $primaryKey = 'user_id';
    protected $fillable =[
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
     'photo',
     'password',
    ];
    
    protected $hidden = [
     'password',
     ];
 
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

}
