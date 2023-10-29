<?php

namespace App\Service;

use App\Modules\ContestModule\ContestDto;
use App\Modules\ContestModule\QuestionDto;
use App\Service\ContestGenerator\ContestGeneratorInterface;
use App\Service\ContestResultSaver\ContestResultSaverInterface;
use App\Service\ContestStorage\ContestStorageInterface;
use App\Service\QuestionAnswerChecker\QuestionAnswerChecker;

class CurrentContestService
{
    public function __construct(
        private readonly ContestStorageInterface $contestStorage,
        private readonly ContestGeneratorInterface $contestGenerator,
        private readonly ContestResultSaverInterface $contestResultSaver,
        private readonly QuestionAnswerChecker $questionAnswerChecker,
    ) {
    }

    public function saveCurrentContest(ContestDto $contestDto): void
    {
        $this->contestStorage->saveContest($contestDto);
    }

    public function getCurrentContest(): ?ContestDto
    {
        return $this->contestStorage->getContest();
    }

    public function isContestStarted(): bool
    {
        return null !== $this->getCurrentContest();
    }

    public function getCurrentQuestion(): ?QuestionDto
    {
        if (!$this->isContestStarted()) {
            $contestDto = $this->contestGenerator->generateShuffledContest();
            $this->saveCurrentContest($contestDto);
        }

        return $this->contestStorage->getContest()?->getCurrentQuestion();
    }

    public function removeContest(): void
    {
        $this->contestStorage->removeContest();
    }

    /**
     * @param array<int, int> $answerKeys
     */
    public function addAnswer(array $answerKeys): void
    {
        $contextDto = $this->contestStorage->getContest();
        if ($contextDto) {
            $contextDto = $this->addAnswerToContest($contextDto, $answerKeys);
            $this->saveCurrentContest($contextDto);
        }
    }

    public function saveResults(): void
    {
        $contextDto = $this->contestStorage->getContest();
        if ($contextDto) {
            $this->contestResultSaver->saveResults($contextDto);
        }
    }

    /**
     * @return array{QuestionDto[], QuestionDto[]}
     */
    public function getSplitResults(): array
    {
        $contextDto = $this->contestStorage->getContest();
        if ($contextDto) {
            return $this->splitResults($contextDto);
        }

        return [null, null];
    }

    protected function splitResults(ContestDto $contestDto): array
    {
        $correctAnswers = [];
        $wrongAnswers = [];
        foreach ($contestDto->getQuestions() as $questionDto) {
            if ($this->questionAnswerChecker->isAnswerCorrect($questionDto)) {
                $correctAnswers[] = $questionDto;
            } else {
                $wrongAnswers[] = $questionDto;
            }
        }

        return [$correctAnswers, $wrongAnswers];
    }

    private function addAnswerToContest(ContestDto $contextDto, array $answerKeys): ContestDto
    {
        foreach ($answerKeys as $answerKey) {
            $questions = $contextDto->getQuestions();
            if (isset($questions[$contextDto->getCurrentQuestionPosition()])) {
                $questions[$contextDto->getCurrentQuestionPosition()]->setIsAnswered(true);
                $options = $questions[$contextDto->getCurrentQuestionPosition()]->getOptions();
                $options[$answerKey]->setIsSelected(true);
                $questions[$contextDto->getCurrentQuestionPosition()]->setOptions($options);
                $contextDto->setQuestions($questions);
            }
        }
        $contextDto->setCurrentQuestionPosition($contextDto->getCurrentQuestionPosition() + 1);

        return $contextDto;
    }
}
