<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\{Project,Personal,Vendor,Listing,Blog,Ptop,Deal,DeviceToken};
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'player_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['last_login_at'];

    protected $appends = ['img','created_at_human_readable','last_login_at_human_readable','last_login_status'];

    public function routeNotificationForOneSignal(): ?string
    {
        return $this->player_id;
    }

    public function deviceTokens(): HasMany
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class,'user_id');
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class,'user_id');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class,'user_id');
    }

    public function ptops(): HasMany
    {
        return $this->hasMany(Ptop::class,'user_id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function personal()
    {
        return $this->hasOne(Personal::class,'user_id');
    }

    public function getImgAttribute()
    {
        if ($this->personal?->profile_image) {
            return asset("storage/profiles/{$this->personal->profile_image}");
        }

        // Get user's first initial (default to 'U' if no name)
        $initial = strtoupper(substr($this->name ?? 'User', 0, 1));

        // Generate a simple avatar using a placeholder service (e.g., Avatar API)
        return "https://ui-avatars.com/api/?name={$initial}&size=128&background=random";
    }


     public function getCreatedAtHumanReadableAttribute()
    {
        $date = Carbon::parse($this->created_at);
        return $date->diffForHumans();
    }

    public function getLastLoginAtHumanReadableAttribute()
    {
        if($this->updated_at) {
            $date = Carbon::parse($this->updated_at);
            return $date->diffForHumans();
        }
        return 'Never';
    }

    public function getLastLoginStatusAttribute()
    {
        if ($this->updated_at) {
            $date = Carbon::parse($this->updated_at);
            

            // Check if the last login was within the last 5 minutes
            if ($date->diffInMinutes(now()) <= 5) {
                return 'Active';
            } else {
                return $date->diffForHumans();
            }
        }
        return 'Recently';
        // $neverdate = Carbon::parse($this->created_at);
        // return $neverdate->diffForHumans();
    }

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
}
