<?php

namespace App\Models;

class Postcode extends \App\Models\Base\Postcode
{
	protected $fillable = [
		'public_body_code',
		'old_postcode',
		'postcode', //code本体
		'prefecture_kana',
		'city_kana',
		'local_kana',
		'prefecture', //県
		'city', //市区町村
		'local', //その他住所
		'indicator_1',
		'indicator_2',
		'indicator_3',
		'indicator_4',
		'indicator_5',
		'indicator_6'
	];

	public function scopeWhereSearch($query, $postcode) {

		$query->where('postcode', $postcode);
		
	}
}
