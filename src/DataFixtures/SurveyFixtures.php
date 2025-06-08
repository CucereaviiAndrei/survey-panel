<?php

namespace App\DataFixtures;

use App\Factory\SurveyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SurveyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SurveyFactory::createMany(10);

        $manager->flush();
    }
}
