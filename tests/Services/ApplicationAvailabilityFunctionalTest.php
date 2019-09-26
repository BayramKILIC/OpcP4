<?php


namespace App\Tests\Services;



use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url,$method,$expectedStatus)
    {
        $client = self::createClient();
        $client->request($method, $url);

        $this->assertEquals($expectedStatus,$client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/','GET', '200'];
        yield ['/ticket', 'POST', '200'];
        yield ['/identification', 'POST', '404'];
        yield ['/recap', 'POST', '404'];
        yield ['/confirmation', 'POST', '404'];

    }
}