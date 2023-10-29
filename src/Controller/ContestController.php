<?php

namespace App\Controller;

use App\Form\QuestionForm;
use App\Modules\ContestModule\OptionDto;
use App\Modules\ContestModule\QuestionDto;
use App\Service\CurrentContestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContestController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(
        CurrentContestService $currentContestService,
    ): Response {
        return $this->render('contest/index.html.twig', [
            'is_contest_started' => $currentContestService->isContestStarted(),
        ]);
    }

    #[Route('/contest', name: 'contest')]
    public function contest(
        CurrentContestService $currentContestService,
    ): Response {
        $questionDto = $currentContestService->getCurrentQuestion();
        if (null === $questionDto) {
            return $this->redirectToRoute('results');
        }
        $contestDto = $currentContestService->getCurrentContest();

        $form = $this->createQuestionForm($questionDto);

        return $this->render('contest/contest.html.twig', [
            'question' => $questionDto,
            'form' => $form,
            'total' => count($contestDto->getQuestions()),
            'current' => $contestDto->getCurrentQuestionPosition() + 1,
        ]);
    }

    #[Route('/submit-question', name: 'submit_question')]
    public function submitQuestion(
        Request $request,
        CurrentContestService $currentContestService,
    ): RedirectResponse {
        $questionDto = $currentContestService->getCurrentQuestion();
        if (!$questionDto) {
            return $this->redirectToRoute('contest');
        }

        $form = $this->createQuestionForm($questionDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $currentContestService->addAnswer($data[QuestionForm::FIELD_ANSWER]);

            return $this->redirectToRoute('contest');
        }

        return $this->redirectToRoute('contest');
    }

    #[Route('/results', name: 'results')]
    public function results(
        CurrentContestService $currentContestService,
    ): Response {
        $currentContestService->saveResults();
        [$successQuestions, $failedQuestions] = $currentContestService->getSplitResults();

        return $this->render('contest/results.html.twig', [
            'success_questions' => $successQuestions,
            'failed_questions' => $failedQuestions,
        ]);
    }

    #[Route('/reset-contest', name: 'reset_contest')]
    public function resetContest(
        CurrentContestService $currentContestService,
    ): RedirectResponse {
        $currentContestService->removeContest();

        return $this->redirectToRoute('homepage');
    }

    #[Route('/restart-contest', name: 'restart_contest')]
    public function restartContest(
        CurrentContestService $currentContestService,
    ): RedirectResponse {
        $currentContestService->removeContest();

        return $this->redirectToRoute('contest');
    }

    private function createQuestionForm(QuestionDto $questionDto): FormInterface
    {
        return $this->createForm(QuestionForm::class, null, [
            'action' => $this->generateUrl('submit_question'),
            QuestionForm::LABEL => $questionDto->getQuestionText(),
            QuestionForm::CHOICES => array_combine(
                array_map(static fn (OptionDto $optionDto) => $optionDto->getOptionText(), $questionDto->getOptions()),
                array_keys($questionDto->getOptions()),
            ),
        ]);
    }
}
