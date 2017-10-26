<?php

include('language/'.LANGUAGE.'.php');

$modules = '
{
	"homepage":
	{
		"users_count":
		{
			"label": ' . get_trad('users_count', $language) . ',
			"icon": "fa-users",
			"color": "blue",
			"show": "true",
			"value": 0
		},
		"users_online":
		{
			"label": ' . get_trad('users_online', $language) . ',
			"icon": "fa-tachometer",
			"color": "blue",
			"show": "true",
			"value": 0
		},
		"server_cash_amount":
		{
			"label": ' . get_trad('server_cash_amount', $language) . ',
			"icon": "fa-money",
			"color": "green",
			"show": "true",
			"value": 0
		},
		"server_bank_amount":
		{
			"label": ' . get_trad('server_bank_amount', $language) . ',
			"icon": "fa-university",
			"color": "green",
			"show": "true",
			"value": 0
		},
		"server_dirty_money":
		{
			"label": ' . get_trad('server_dirty_money', $language) . ',
			"icon": "fa-diamond",
			"color": "red",
			"show": "true",
			"value": 0
		}
	}
}

';

function get_trad($item, $language) 
{
	return $language[$item];
}

?>