<?php

namespace App\Models;

class Prefecture extends \App\Models\Base\Prefecture
{
	protected $fillable = [
		'id',
		'name',
		'display_name',
		'area_id'
	];

	public static function selectlist()
	{
		$prefectures = Prefecture::all();
		$list = array();
    	$list += array( "" => "" ); //selectlistの先頭を空に
		foreach ($prefectures as $prefecture) {
			$list += array( $prefecture->id => $prefecture->display_name );
		}
		return $list;
	}
}