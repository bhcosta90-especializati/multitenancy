<?php


namespace App\Models\Tenant;


class User extends \App\Models\User
{
    protected $fillable = [
        'name', 'email', 'password', 'company_id', 'admin'
    ];
}
