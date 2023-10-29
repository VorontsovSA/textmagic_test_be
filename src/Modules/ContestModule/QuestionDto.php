<?php

namespace App\Modules\ContestModule;

class QuestionDto
{
    private string $questionText;

    /**
     * @var OptionDto[]
     */
    private array $options;

    private bool $isAnswered;

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function isAnswered(): bool
    {
        return $this->isAnswered;
    }

    public function setQuestionText(string $questionText): void
    {
        $this->questionText = $questionText;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setIsAnswered(bool $isAnswered): void
    {
        $this->isAnswered = $isAnswered;
    }
}
