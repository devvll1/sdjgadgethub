<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table ='employees';
    protected $primaryKey = 'employee_id';
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
     'role_id',
     'username',
     'photo',
     'password',
    ];
    
    protected $hidden = [
     'password',
     ];
 
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}




