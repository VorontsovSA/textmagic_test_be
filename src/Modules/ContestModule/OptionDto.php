<?php

namespace App\Modules\ContestModule;

class OptionDto
{
    private int $id;

    private string $optionText;

    private bool $isCorrect;

    private bool $isSelected;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOptionText(): string
    {
        return $this->optionText;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function isSelected(): bool
    {
        return $this->isSelected;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setOptionText(string $optionText): void
    {
        $this->optionText = $optionText;
    }

    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }

    public function setIsSelected(bool $isSelected): void
    {
        $this->isSelected = $isSelected;
    }
}
