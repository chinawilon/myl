<?php

namespace App\Repositories;

use App\Models\Package;

class PackageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Package::class;
    }
}
