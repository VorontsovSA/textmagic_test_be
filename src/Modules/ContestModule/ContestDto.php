<?php

namespace App\Modules\ContestModule;

use Symfony\Component\Uid\Uuid;

class ContestDto
{
    private string $contestId;

    /**
     * @var QuestionDto[]
     */
    private array $questions;

    private int $currentQuestionPosition;

    public function __construct()
    {
        $this->contestId = Uuid::v4();
        $this->currentQuestionPosition = 0;
    }

    public function getContestId(): string
    {
        return $this->contestId;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): void
    {
        $this->questions = $questions;
    }

    public function getCurrentQuestionPosition(): int
    {
        return $this->currentQuestionPosition;
    }

    public function setCurrentQuestionPosition(int $currentQuestionPosition): void
    {
        $this->currentQuestionPosition = $currentQuestionPosition;
    }

    public function getCurrentQuestion(): ?QuestionDto
    {
        return $this->questions[$this->getCurrentQuestionPosition()] ?? null;
    }
}
