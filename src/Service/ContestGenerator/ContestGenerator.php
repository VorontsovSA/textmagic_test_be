<?php

namespace App\Service\ContestGenerator;

use App\Modules\ContestModule\ContestDto;
use App\Modules\ContestModule\OptionDto;
use App\Modules\ContestModule\QuestionDto;
use App\Repository\QuestionRepository;

class ContestGenerator implements ContestGeneratorInterface
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
    ) {
    }

    public function generateShuffledContest(): ContestDto
    {
        $questionEntities = $this->questionRepository->findAll();
        $contestDto = new ContestDto();
        $questions = [];
        foreach ($questionEntities as $questionEntity) {
            $questionDto = new QuestionDto();
            $questionDto->setQuestionText($questionEntity->getQuestionText());
            $options = [];
            foreach ($questionEntity->getOptions() as $optionEntity) {
                $optionDto = new OptionDto();
                $optionDto->setId($optionEntity->getId());
                $optionDto->setOptionText($optionEntity->getOptionText());
                $optionDto->setIsCorrect($optionEntity->getIsCorrect());
                $optionDto->setIsSelected(false);
                $options[] = $optionDto;
            }
            shuffle($options);
            $questionDto->setOptions($options);
            $questions[] = $questionDto;
        }
        shuffle($questions);
        $contestDto->setQuestions($questions);

        return $contestDto;
    }
}
