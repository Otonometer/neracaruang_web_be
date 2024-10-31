<?php

namespace App;

use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasRoles;
    use Notifiable;
    use HasApiTokens;

    protected $connection = 'mysql';
    protected $guard_name = 'web';
    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'password',
        'image',
        'token_sso'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'image' => 'string',
        'token_sso' => 'string',
        'remember_token' => 'string'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }
}
