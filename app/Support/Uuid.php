<?php


namespace App\Support;


use YourAppRocks\EloquentUuid\Traits\HasUuid;

trait Uuid
{
    use HasUuid;

    protected $uuidColumnName = 'id';

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

}
