<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 50; $i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigitNotNull);
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $this->addReference('season_' . $i, $season);
            $season->setProgram($this->getReference('program_' . $i % 6));
            $manager->persist($season);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
