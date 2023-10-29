<?php

namespace App\Service\ContestResultSaver;

use App\Entity\Answer;
use App\Entity\Result;
use App\Modules\ContestModule\ContestDto;
use App\Repository\OptionRepository;
use App\Repository\ResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ContestResultSaver implements ContestResultSaverInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ResultRepository $resultRepository,
        private readonly OptionRepository $optionRepository,
    ) {
    }

    public function saveResults(ContestDto $contestDto): void
    {
        $resultEntity = $this->resultRepository->findOneBy([
            'uuid' => $contestDto->getContestId(),
        ]);

        if ($resultEntity) {
            return;
        }

        $resultEntity = new Result();
        $resultEntity->setUuid(Uuid::fromString($contestDto->getContestId()));

        $this->entityManager->persist($resultEntity);
        $this->entityManager->flush();

        foreach ($contestDto->getQuestions() as $questionDto) {
            foreach ($questionDto->getOptions() as $optionDto) {
                if ($optionDto->isSelected()) {
                    $answerEntity = new Answer();
                    $answerEntity->setResult($resultEntity);
                    $answerEntity->setOption($this->optionRepository->find($optionDto->getId()));
                    $this->entityManager->persist($answerEntity);
                }
            }
        }

        $this->entityManager->flush();
    }
}
