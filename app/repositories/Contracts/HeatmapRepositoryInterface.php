<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface HeatmapRepositoryInterface
{
    public function getFilteredReports(array $filters): Collection;
    public function getFilteredServices(array $filters): Collection;
}