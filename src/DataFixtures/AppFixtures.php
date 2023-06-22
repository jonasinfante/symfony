<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('jonas');
        $user->setPassword($this->hasher->hashPassword($user, 'jonas'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $admin = new User();
        $admin->setUsername('john');
        $admin->setPassword($this->hasher->hashPassword($admin, 'john'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $actionGenre = new Genre();
        $actionGenre->setName('Action');
        $manager->persist($actionGenre);

        $scifiGenre = new Genre();
        $scifiGenre->setName('Sci-Fi');
        $manager->persist($scifiGenre);

        $comedyGenre = new Genre();
        $comedyGenre->setName('Comedy');
        $manager->persist($comedyGenre);

        $dramaGenre = new Genre();
        $dramaGenre->setName('Drama');
        $manager->persist($dramaGenre);

        $movie = new Movie();
        $movie->setTitle('The Shawshank Redemption');
        $movie->setReleasedAt(new \DateTimeImmutable('1994-10-14'));
        $movie->setCreatedBy($admin);
        $movie->addGenre($actionGenre);
        $movie->addGenre($scifiGenre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Godfather');
        $movie->setReleasedAt(new \DateTimeImmutable('1972-03-24'));
        $movie->setCreatedBy($admin);
        $movie->addGenre($dramaGenre);
        $movie->addGenre($actionGenre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Dark Knight');
        $movie->setReleasedAt(new \DateTimeImmutable('2008-07-18'));
        $movie->setCreatedBy($admin);
        $movie->addGenre($actionGenre);
        $movie->addGenre($dramaGenre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Batman');
        $movie->setReleasedAt(new \DateTimeImmutable('2022-03-04'));
        $movie->setCreatedBy($admin);
        $movie->addGenre($actionGenre);
        $movie->addGenre($dramaGenre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Lord of the Rings: The Return of the King');
        $movie->setCreatedBy($admin);
        $movie->setReleasedAt(new \DateTimeImmutable('2003-12-17'));
        $movie->addGenre($actionGenre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Hangover');
        $movie->setReleasedAt(new \DateTimeImmutable('2009-06-05'));
        $movie->setCreatedBy($admin);
        $movie->addGenre($comedyGenre);
        $manager->persist($movie);

        $manager->flush();
    }
}
