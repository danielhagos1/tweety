<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','avatar','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        #return asset($value);
        
        #return asset($value ?: '/images/default-avatar.jpg');

        
       return "https://i.pravatar.cc/200?u=". $this->email;
    }

    public function setPasswordAttribute($value){

        $this->attributes['password'] = bcrypt($value);
        
    }

    public function timeline()
    {
        //include all of the user's tweets
        //as well as the tweets of everyone
        //they follow...in descending order by date.
        $friends = $this->follows()->pluck('id');

        return Tweet::whereIn('user_id', $friends)
            ->orWhere('user_id', $this->id)
            ->latest()->get();
            

    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class)->latest();
    }

    public function follow(User $user)
    {
        return $this->follows()->save($user);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
    }
    
    public function following(User $user){
        
        return $this->follows()->where('following_user_id', $user->id)->exists();
        
    }

    public function unfollow(User $user){
        return $this->follows()->detach($user);
    }
    
    public function toggleFollow(User $user){
        if($this->following($user))
        
        {
            
            return $this->unfollow($user);
           
        }
        
        return $this->follow($user);
            
    }

    public function path($append = '')
    {
        
        $path = route('profile', $this->username);

        return $append ? "{$path}/{$append}" : $path;
    }

}