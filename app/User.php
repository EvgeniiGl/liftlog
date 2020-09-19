<?php

namespace App;

use App\Models\Traits\AccessToken;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, AccessToken;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'login',
        'phone',
        'password',
        'role',
        'access_users',
        'access_records',
        'notificate',
    ];
    /**
     * Status notificate
     *
     * @var array
     */
    private const NOTIFICATE_STATUS = [
        1 => 'откл',
        2 => 'свои',
        3 => 'все'
    ];

    /**
     * @var string date format
     */
    protected $dateFormat = 'Y-m-d';

    public function __construct($attributes = [])
    {
        //fix conflict MSSQL 2013 year
        $this->dateFormat = config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat');
        parent::__construct($attributes);
    }

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

    static private $SIPMLE_ROLES = [
        "механик",
        "лифтер",
        "электроник",
        "связист",
        'диспетчер',
        "администратор",
        "руководитель"
    ];

    /**
     * @const array
     */
    static private $ROLES = [
    ];

    static public function getRolesUsers()
    {
        return array_merge(self::$ROLES, self::$SIPMLE_ROLES);
    }

    static public function getAdminRolesUsers()
    {
        return self::$ROLES;
    }

    static public function getSimpleRolesUsers()
    {
        return self::$SIPMLE_ROLES;
    }

    public function recordsMaker()
    {
        return $this->hasMany('Modules\Records\Models\Record', 'maker_id', 'id');
    }

    /**
     * returns the id of a given notification staus
     *
     * @param string $notificate user's notification status
     * @return int notificateID
     */
    public static function getNotificateID($notificate)
    {
        return array_search($notificate, self::NOTIFICATE_STATUS);
    }

    /**
     * get user notificate
     */
    public function getNotificateAttribute()
    {
        return self::NOTIFICATE_STATUS[$this->attributes['notificate']];
    }

    /**
     * set user notificate
     */
    public function setNotificateAttribute($value)
    {
        $notificateID = self::getNotificateID($value);
        if ($notificateID) {
            $this->attributes['notificate'] = $notificateID;
        }
    }

    /**
     * get user notificate status id
     */
    public function getNotificateIdAttribute()
    {
        return $this->attributes['notificate'];
    }

    static public function getNotifications()
    {
        return self::NOTIFICATE_STATUS;
    }

    /**
     * Get the devices.
     */
    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }
}
