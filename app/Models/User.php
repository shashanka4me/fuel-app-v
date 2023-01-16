<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

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

    public function saveCustomer($data){
        $result = DB::table('customer')->insert($data);
        return $result;
    }

    public function getByMobile($mobile){
        $result = DB::table('customer')->where('mobile',$mobile)->first();
        return $result;
    }

    public function updateCustomer($data,$id){
        $result = DB::table('customer')->where('id',$id)->update($data);
        return $result;
    }

    public function getByd($id){
        $result = DB::table('customer')->where('id',$id)->first();
        return $result;
    }

    public function getAllCustomers(){
        $result = DB::table('customer')->get();
        return $result;
    }
}
