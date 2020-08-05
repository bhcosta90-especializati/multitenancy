<?php

namespace App\Models;

use App\Observers\CompanyCreateObserver;
use App\Support\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use Uuid, SoftDeletes;

    private static $company;

    protected $dispatchesEvents = [
        'creating' => CompanyCreateObserver::class,
        'created' => CompanyCreateObserver::class,
    ];

    protected $fillable = [
        'name',
        'domain',
        'document',
        'bd_database',
        'bd_hostname',
        'bd_username_read',
        'bd_username_write',
        'bd_password_read',
        'bd_password_write',
    ];

    public static function getCompanyByHost(): ?Company
    {
        if (self::$company == null) {
            $request = request();

            $company = self::getCompany($request->getHost());

            #TODO fazer a parte de subdominio
            if (empty($company)) {
                $company = self::getCompany(collect(explode('.', $request->getHost()))->first());
            }
            self::$company = $company;
            return $company;
        }

        return self::$company;
    }

    public static function getCompany(string $host): ?Company
    {
        return Company::whereDomain($host)->first();
    }

    public function setBdPasswordReadAttribute($password)
    {
        $this->attributes['bd_password_read'] = base64_encode(env('JWT_TOKEN') . $password);
    }

    public function getBdPasswordReadAttribute($password)
    {
        return str_replace(env('JWT_TOKEN'), '', base64_decode($password));
    }

    public function setBdPasswordWriteAttribute($password)
    {
        $this->attributes['bd_password_write'] = base64_encode(env('JWT_TOKEN') . $password);
    }

    public function getBdPasswordWriteAttribute($password)
    {
        return str_replace(env('JWT_TOKEN'), '', base64_decode($password));
    }

    public function setDocumentAttribute($document)
    {
        $this->attributes['document'] = preg_replace("/[^0-9]/", "", $document);
    }
}
