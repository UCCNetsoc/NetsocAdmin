<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MySQLUser extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mysql_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'username', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function user(){
        return $this->hasOne('App\User');
    }
}
