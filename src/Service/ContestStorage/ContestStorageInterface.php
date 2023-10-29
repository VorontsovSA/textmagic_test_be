<?php

namespace App\Service\ContestStorage;

use App\Modules\ContestModule\ContestDto;

interface ContestStorageInterface
{
    public function removeContest(): void;

    public function saveContest(ContestDto $contestDto): void;

    public function getContest(): ?ContestDto;
}
