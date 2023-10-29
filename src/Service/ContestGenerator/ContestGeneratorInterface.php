<?php

namespace App\Service\ContestGenerator;

use App\Modules\ContestModule\ContestDto;

interface ContestGeneratorInterface
{
    public function generateShuffledContest(): ContestDto;
}
