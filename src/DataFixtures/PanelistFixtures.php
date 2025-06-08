<?php

namespace App\DataFixtures;

use App\Factory\PanelistFactory;
use App\Factory\SurveyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PanelistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PanelistFactory::createMany(20, function () {
            return [
                'surveys' => SurveyFactory::randomRange(1, 3),
            ];
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SurveyFixtures::class,
        ];
    }
}
