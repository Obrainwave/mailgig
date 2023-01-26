<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function suspend()
    {
		  return ($this->suspend == true) ? true : false;
    }

    public function superAdmin()
    {
		  return ($this->admin == true && ($this->account == 9) && $this->is_root == false) ? true : false;
    }

    public function admin()
    {
		  return ($this->admin == true && ($this->account == 5) && $this->is_root == false) ? true : false;
    }

    public function isSupervisor()
    {
		  return ($this->admin == true && ($this->account == 4) && $this->is_root == false) ? true : false;
    }

    public function rootUser()
    {
		  return ($this->admin == true && $this->account == 9 && $this->is_root == true) ? true : false;
    }

    public function isUser()
    {
		  return ($this->admin == false && $this->account == 1) ? true : false;
    }

    public function isInspector()
    {
		  return ($this->admin == false && $this->account == 3) ? true : false;
    }

    public function isActive()
    {
		  return ($this->active == true) ? true : false;
    }

    public function activation_token()
    {
        return $this->hasOne(UserActivation::class);
    }

    public function assignedFarms()
    {
        return $this->hasMany(FarmAssigned::class);
    }

    public function assignedFarmers()
    {
        return $this->hasMany(FarmerAssigned::class);
    }

    public function assignedInspectors()
    {
        return $this->hasMany(InspectorAssigned::class, 'supervisor_id');
    }

    public function assign()
    {
        return $this->hasOne(InspectorAssigned::class, 'inspector_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
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
}
