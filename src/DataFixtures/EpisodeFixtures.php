<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 250; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence(4, true));
            $episode->setNumber($faker->randomDigitNotNull);
            $episode->setSynopsis($faker->realText(255));

            $episode->setSeason($this->getReference('season_' . $i % 50));
            $manager->persist($episode);
        }
        $manager->flush();

    }
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}