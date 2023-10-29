<?php

namespace App\Service\ContestResultSaver;

use App\Modules\ContestModule\ContestDto;

interface ContestResultSaverInterface
{
    public function saveResults(ContestDto $contestDto): void;
}
