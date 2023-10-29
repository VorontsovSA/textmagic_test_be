<?php

namespace App\Service\QuestionAnswerChecker;

use App\Modules\ContestModule\QuestionDto;

interface QuestionAnswerCheckerInterface
{
    public function isAnswerCorrect(QuestionDto $questionDto): bool;
}
