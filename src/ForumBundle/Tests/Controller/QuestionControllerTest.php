<?php

namespace ForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerTest extends WebTestCase
{
    public function testDisplayquestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/question');
    }

    public function testAddquestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AddQuestion');
    }

}
