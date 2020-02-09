<?php

namespace TasksBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TasksControllerTest extends WebTestCase
{
    public function testAddtasks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addTasks');
    }

}
