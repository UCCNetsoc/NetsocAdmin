<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MySQLDatabase extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mysql_databases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'db_name'];

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
