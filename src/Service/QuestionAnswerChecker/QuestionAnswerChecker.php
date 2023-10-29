<?php

namespace App\Service\QuestionAnswerChecker;

use App\Modules\ContestModule\QuestionDto;

class QuestionAnswerChecker implements QuestionAnswerCheckerInterface
{
    public function isAnswerCorrect(QuestionDto $questionDto): bool
    {
        $correctAnswers = 0;
        foreach ($questionDto->getOptions() as $optionDto) {
            if ($optionDto->isCorrect() && $optionDto->isSelected()) {
                ++$correctAnswers;
            }
            if (!$optionDto->isCorrect() && $optionDto->isSelected()) {
                return false;
            }
        }

        return $correctAnswers > 0;
    }
}
