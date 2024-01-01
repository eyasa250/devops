<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    public function testClientIndex()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/client/');

        // Vérifier que la réponse est un succès
        $this->assertResponseIsSuccessful();

        // Vérifier la présence du tableau
        $this->assertSelectorExists('table.table');

        // Vérifier que le tableau contient des lignes pour les clients
        $this->assertGreaterThan(0, $crawler->filter('table.table tbody tr')->count(), 'Le tableau doit contenir au moins une ligne pour un client.');

        // Vous pouvez aussi vérifier la présence et le contenu des entêtes de colonnes
        $this->assertSelectorTextContains('table.table thead tr th:first-child', 'Id');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(2)', 'Nom');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(3)', 'Prenom');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(4)', 'Adresse');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(5)', 'Cin');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(6)', 'actions');


    }

    public function testLocationIndex()
    {
        $client = static::createClient();

        // Simuler une requête GET sur l'index des locations
        $crawler = $client->request('GET', '/location/');

        // Vérifier que la réponse est un succès
        $this->assertResponseIsSuccessful();

        // Vérifier la présence du tableau
        $this->assertSelectorExists('table.table');

        // Vérifier que le tableau contient des lignes pour les locations
        $this->assertGreaterThan(0, $crawler->filter('table.table tbody tr')->count(), 'Le tableau doit contenir au moins une ligne pour une location.');

        // Vérifier la présence et le contenu des entêtes de colonnes
        $this->assertSelectorTextContains('table.table thead tr th:first-child', 'Id');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(2)', 'DateD');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(3)', 'DateA');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(4)', 'Prix');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(5)', 'Client');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(6)', 'Voiture');
        $this->assertSelectorTextContains('table.table thead tr th:nth-child(7)', 'actions');

        if ($crawler->filter('table.table tbody tr')->count() == 0) {
            $this->assertSelectorTextContains('table.table tbody tr td', 'no records found');
        }

    }
}

