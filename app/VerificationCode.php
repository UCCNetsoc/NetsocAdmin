<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VerificationCode extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'verification_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'confirmation_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
