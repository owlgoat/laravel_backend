<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Config;

class Company extends \App\Models\Base\Company
{
	protected $fillable = [
		'name',
		'email',
		'prefecture_id',
		'phone',
		'postcode',
		'city',
		'local',
		'street_address',
		'business_hour',
		'regular_holiday',
		'image',
		'fax',
		'url',
		'license_number'
	];
}
