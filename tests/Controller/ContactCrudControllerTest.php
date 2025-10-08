<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactCrudControllerTest extends WebTestCase
{
    public function testPageTitle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Formulaire de contact');
    }

    public function testFormFields(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input[name="form[firstName]"]');
        $this->assertSelectorExists('input[name="form[name]"]');
        $this->assertSelectorExists('textarea[name="form[message]"]');
    }

    public function testFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Envoyer')->form();
        $form['form[firstName]'] = 'John';
        $form['form[name]'] = 'Doe';
        $form['form[message]'] = 'test message';

        $client->submit($form);
        $this->assertResponseRedirects('/');

        $client->request('GET', '/liste');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('table', 'John');
        $this->assertSelectorTextContains('table', 'Doe');
    }

    public function testEmptyFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Envoyer')->form();
        $form['form[firstName]'] = '';
        $form['form[name]'] = '';
        $form['form[message]'] = '';

        $client->submit($form);

        $this->assertResponseStatusCodeSame(500);
    }
}
