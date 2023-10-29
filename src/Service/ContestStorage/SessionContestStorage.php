<?php

namespace App\Service\ContestStorage;

use App\Modules\ContestModule\ContestDto;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionContestStorage implements ContestStorageInterface
{
    private const SESSION_CONTEST_KEY = 'contest';

    private SessionInterface $session;

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
        $this->session = $this->requestStack->getSession();
    }

    public function removeContest(): void
    {
        $this->session->remove(self::SESSION_CONTEST_KEY);
    }

    public function saveContest(ContestDto $contestDto): void
    {
        $this->session->set(self::SESSION_CONTEST_KEY, $contestDto);
    }

    public function getContest(): ?ContestDto
    {
        return $this->session->get(self::SESSION_CONTEST_KEY);
    }
}
