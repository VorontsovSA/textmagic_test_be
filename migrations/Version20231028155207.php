<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Option;
use App\Entity\Question;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231028155207 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    private const DATA = [
        [
            'text' => '1 + 1 = ',
            'options' => [
                ['text' => '3', 'is_correct' => false],
                ['text' => '2', 'is_correct' => true],
                ['text' => '0', 'is_correct' => false],
            ],
        ],
        [
            'text' => '2 + 2 = ',
            'options' => [
                ['text' => '4', 'is_correct' => true],
                ['text' => '3 + 1', 'is_correct' => true],
                ['text' => '10', 'is_correct' => false],
            ],
        ],
        [
            'text' => '3 + 3 = ',
            'options' => [
                ['text' => '1 + 5', 'is_correct' => true],
                ['text' => '1', 'is_correct' => false],
                ['text' => '6', 'is_correct' => true],
                ['text' => '2 + 4', 'is_correct' => true],
            ],
        ],
        [
            'text' => '4 + 4 = ',
            'options' => [
                ['text' => '8', 'is_correct' => true],
                ['text' => '4', 'is_correct' => false],
                ['text' => '0', 'is_correct' => false],
                ['text' => '0 + 8', 'is_correct' => true],
            ],
        ],
        [
            'text' => '5 + 5 = ',
            'options' => [
                ['text' => '6', 'is_correct' => false],
                ['text' => '18', 'is_correct' => false],
                ['text' => '10', 'is_correct' => true],
                ['text' => '9', 'is_correct' => false],
                ['text' => '0', 'is_correct' => false],
            ],
        ],
        [
            'text' => '6 + 6 = ',
            'options' => [
                ['text' => '3', 'is_correct' => false],
                ['text' => '9', 'is_correct' => false],
                ['text' => '0', 'is_correct' => false],
                ['text' => '12', 'is_correct' => true],
                ['text' => '5 + 7', 'is_correct' => true],
            ],
        ],
        [
            'text' => '7 + 7 = ',
            'options' => [
                ['text' => '5', 'is_correct' => false],
                ['text' => '14', 'is_correct' => true],
            ],
        ],
        [
            'text' => '8 + 8 = ',
            'options' => [
                ['text' => '16', 'is_correct' => true],
                ['text' => '12', 'is_correct' => false],
                ['text' => '9', 'is_correct' => false],
                ['text' => '5', 'is_correct' => false],
            ],
        ],
        [
            'text' => '9 + 9 = ',
            'options' => [
                ['text' => '18', 'is_correct' => true],
                ['text' => '9', 'is_correct' => false],
                ['text' => '17 + 1', 'is_correct' => true],
                ['text' => '2 + 16', 'is_correct' => true],
            ],
        ],
        [
            'text' => '10 + 10 = ',
            'options' => [
                ['text' => '0', 'is_correct' => false],
                ['text' => '2', 'is_correct' => false],
                ['text' => '8', 'is_correct' => false],
                ['text' => '20', 'is_correct' => true],
            ],
        ],
    ];

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        foreach (static::DATA as $question) {
            $questionEntity = new Question();
            $questionEntity->setQuestionText($question['text']);
            $entityManager->persist($questionEntity);
//            $entityManager->flush();
            foreach ($question['options'] as $option) {
                $optionEntity = new Option();
                $optionEntity->setQuestion($questionEntity);
                $optionEntity->setOptionText($option['text']);
                $optionEntity->setIsCorrect($option['is_correct']);
                $entityManager->persist($optionEntity);
            }
            $entityManager->flush();
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE Option CASCADE');
        $this->addSql('TRUNCATE TABLE Question CASCADE');
    }
}
