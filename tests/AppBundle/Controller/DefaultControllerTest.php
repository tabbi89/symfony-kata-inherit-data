<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testSubmitValidDataIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $formData['user']['username'] = 'valid';
        $formData['user']['location']['address'] = 'valid';
        $formData['user']['location']['zipCode'] = 'valid';

        $form = $crawler->selectButton('submit')->form();
        $crawler = $client->submit($form, $formData);

        $this->assertNotContains('This value should not be null.', $crawler->filter('#user')->text());
    }

    public function testSubmiInvalidtDataIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $formData['user']['username'] = '';
        $formData['user']['location']['address'] = '';
        $formData['user']['location']['zipCode'] = '';

        $form = $crawler->selectButton('submit')->form();
        $crawler = $client->submit($form, $formData);

        $this->assertContains('This value should not be null.', $crawler->filter('#user')->text());
    }
}
