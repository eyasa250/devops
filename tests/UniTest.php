<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Modele;
use App\Entity\User;
use App\Entity\Voiture;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UniTest extends TestCase
{
    //*****************client*********//
    public function testClient(): void
    {
        $client = new Client();
        // Testez les setters et les getters
        $client->setNom("Nour el houda");
        $this->assertSame("Nour el houda", $client->getNom(), "Le getter ou le setter pour le nom est défectueux.");

        $client->setPrenom("ben ghayadha");
        $this->assertSame("ben ghayadha", $client->getPrenom(), "Le getter ou le setter pour le prénom est défectueux.");

        $client->setAdresse("123 Rue de la République");
        $this->assertSame("123 Rue de la République", $client->getAdresse(), "Le getter ou le setter pour l'adresse est défectueux.");

        $client->setCin("11661200");
        $this->assertSame("11661200", $client->getCin(), "Le getter ou le setter pour le CIN est défectueux.");

    }
    public function testLocation(): void
    {
        $location = new Location();

        // Tester les setters et getters pour les dates
        $dateDebut = new \DateTime('2023-12-30');
        $location->setDateD($dateDebut);
        $this->assertSame($dateDebut, $location->getDateD(), "Le getter ou le setter pour la date de début est défectueux.");

        $dateFin = new \DateTime('2024-01-03');
        $location->setDateA($dateFin);
        $this->assertSame($dateFin, $location->getDateA(), "Le getter ou le setter pour la date de fin est défectueux.");

        // Tester le setter et le getter pour le prix
        $location->setPrix(100.0);
        $this->assertSame(100.0, $location->getPrix(), "Le getter ou le setter pour le prix est défectueux.");

        // Tester la relation avec l'entité Client
        $client = new Client();
        $location->setClient($client);
        $this->assertSame($client, $location->getClient(), "La relation avec l'entité Client n'est pas correctement gérée.");

        // Tester la relation avec l'entité Voiture
        $voiture = new Voiture();
        $location->setVoiture($voiture);
        $this->assertSame($voiture, $location->getVoiture(), "La relation avec l'entité Voiture n'est pas correctement gérée.");

        // verifier l'instance est du bon type
        $this->assertInstanceOf(Location::class, $location, "L'instance n'est pas du type Location.");
    }

/***********voiture*************/

    public function testVoiture(): void
    {
        $voiture = new Voiture();

        // Tester les setters et getters pour la série
        $voiture->setSerie('123ABC');
        $this->assertSame('123ABC', $voiture->getSerie(), "Le getter ou le setter pour la série est défectueux.");

        // Tester les setters et getters pour la date de mise en marché
        $dateMM = new \DateTime('2018-06-15');
        $voiture->setDateMM($dateMM);
        $this->assertSame($dateMM, $voiture->getDateMM(), "Le getter ou le setter pour la date de mise en marché est défectueux.");

        // Tester le setter et le getter pour le prix par jour
        $voiture->setPrixJour(50.0);
        $this->assertSame(50.0, $voiture->getPrixJour(), "Le getter ou le setter pour le prix par jour est défectueux.");

        // Tester l'ajout et la suppression de locations
        $location = new Location();
        $voiture->addLocation($location);
        $this->assertCount(1, $voiture->getLocations(), "L'ajout de la location à la collection a échoué.");

        $voiture->removeLocation($location);
        $this->assertCount(0, $voiture->getLocations(), "La suppression de la location de la collection a échoué.");

        // Tester la relation avec l'entité Modele
        $modele = new Modele();
        $voiture->setModele($modele);
        $this->assertSame($modele, $voiture->getModele(), "La relation avec l'entité Modele n'est pas correctement gérée.");

        // verif  l'instance est du bon type
        $this->assertInstanceOf(Voiture::class, $voiture, "L'instance n'est pas du type Voiture.");
    }

/***************User****************/
    public function testUser(): void
    {
        $user = new User();

        // Tester le setter et le getter pour l'email
        $user->setEmail('nour@gmail.com');
        $this->assertSame('nour@gmail.com', $user->getEmail(), "Le getter ou le setter pour l'email est défectueux.");

        // Tester le UserIdentifier (qui est également l'email dans ce cas)
        $this->assertSame('nour@gmail.com', $user->getUserIdentifier(), "La méthode getUserIdentifier ne retourne pas le bon identifiant.");

        // Tester les setters et getters pour les roles
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->setRoles($roles);
        $this->assertContains('ROLE_USER', $user->getRoles(), "Le rôle ROLE_USER doit toujours être présent.");
        $this->assertContains('ROLE_ADMIN', $user->getRoles(), "Le rôle ROLE_ADMIN doit être défini par le setter.");

        // Tester le setter et le getter pour le mot de passe
        $user->setPassword('hashed_password');
        $this->assertSame('hashed_password', $user->getPassword(), "Le getter ou le setter pour le mot de passe est défectueux.");


        // Assurez-vous que l'instance est du bon type
        $this->assertInstanceOf(UserInterface::class, $user, "L'instance User n'implémente pas UserInterface.");
        $this->assertInstanceOf(PasswordAuthenticatedUserInterface::class, $user, "L'instance User n'implémente pas PasswordAuthenticatedUserInterface.");
    }
/*************Model**************/


    public function testModele(): void
    {
        $modele = new Modele();

        // Tester les setters et getters pour libelle
        $modele->setLibelle('BMW');
        $this->assertSame('BMW', $modele->getLibelle(), "Le getter ou le setter pour le libelle est défectueux.");

        // Tester les setters et getters pour pays
        $modele->setPays('France');
        $this->assertSame('France', $modele->getPays(), "Le getter ou le setter pour le pays est défectueux.");

        // Tester l'ajout et la suppression de voitures
        $voiture = new Voiture();
        $modele->addVoiture($voiture);
        $this->assertCount(1, $modele->getVoitures(), "L'ajout de la voiture à la collection a échoué.");
        $this->assertTrue($modele->getVoitures()->contains($voiture), "La voiture doit être contenue dans la collection après l'ajout.");

        $modele->removeVoiture($voiture);
        $this->assertCount(0, $modele->getVoitures(), "La suppression de la voiture de la collection a échoué.");
        $this->assertFalse($modele->getVoitures()->contains($voiture), "La voiture ne doit pas être contenue dans la collection après la suppression.");

        // VERIFIER l'instance est du bon type
        $this->assertInstanceOf(Modele::class, $modele, "L'instance n'est pas du type Modele.");
    }


}

