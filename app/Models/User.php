<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{

   use HasFactory, Notifiable, Searchable;
   use LaratrustUserTrait;
   use HasApiTokens;

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $guarded = [""];

   protected $searchable = [
      'Region.name', 'name', 'email', 'phone_number',
   ];
   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
      'email_verified_at' => 'datetime',
   ];
   /**
    * Get all of the Targets for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function TargetSales(): HasMany
   {
      return $this->hasMany(SalesTarget::class, 'user_code', 'user_code');
   }
   /**
    * Get all of the TargetLeads for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function TargetLeads(): HasMany
   {
      return $this->hasMany(LeadsTargets::class, 'user_code', 'user_code');
   }
   /**
    * Get all of the TargetsOrder for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function TargetsOrder(): HasMany
   {
      return $this->hasMany(OrdersTarget::class, 'user_code', 'user_code');
   }
   /**
    * Get all of the TargetsVisit for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function TargetsVisit(): HasMany
   {
      return $this->hasMany(VisitsTarget::class, 'user_code', 'user_code');
   }
   /**
    * Get the Region that owns the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Region(): BelongsTo
   {
      return $this->belongsTo(Region::class,  'route_code', 'id');
   }


   public function conversations()
   {
       
       return $this->hasMany(Conversation::class,'sender_id')->orWhere('receiver_id',$this->id)->whereNotDeleted();
   }

   /**
    * The channels the user receives notification broadcasts on.
    */
   public function receivesBroadcastNotificationsOn(): string
   {
       return 'users.'.$this->id;
   }
}
