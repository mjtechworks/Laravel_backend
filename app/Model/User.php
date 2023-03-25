<?php

namespace App\Model;

use App\Model\Traits\DisplayDateFormat;
use App\Model\Traits\HasStatuses;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasMediaTrait;
    use LogsActivity;
    use DisplayDateFormat, HasStatuses;

    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logFillable = true;
    protected static $recordEvents = ['updated', 'deleted'];

    public function setPasswordAttribute($value) { 
        $this->attributes['password'] = bcrypt($value); 
    }

    public function getEditLinkAttribute() { return route('backend.user.edit', $this); }

    public function getDestroyLinkAttribute() { return route('backend.user.destroy', $this); }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop(\Spatie\Image\Manipulations::CROP_CENTER, 100, 100);
            });
    }

    public function getHasAvatarAttribute()
    {
        return !empty($this->getMedia('avatar')[0]);
    }

    public function getAvatarAttribute()
    {
        return url($this->getFirstMediaUrl('avatar'));
    }

    public function getAvatarThumbAttribute()
    {
        if (!empty($this->getMedia('avatar')[0])) {
            return $this->getMedia('avatar')[0]->getFullUrl('thumb');
        }
        return asset('images/backend/avatar.jpg');
    }

    public function storeRoles()
    {
        $roles = request()->has('roles') ? request('roles') : [] ;
        $this->syncRoles($roles);
    }

    public function storeAvatar()
    {
        if (request()->has('profile_image_file')) {
            // $this->addMedia(request()->file('profile_image_file'))
            $this->addMediaFromRequest('profile_image_file')
                ->sanitizingFileName(function($fileName) {
                  return sanitizeFileName($fileName);
                })
                ->toMediaCollection('avatar');
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
