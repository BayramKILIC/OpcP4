<?php


namespace App\Tests\Services;


class ApplicationAvailabilityFunctionalTest
{
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->getStatusCode());
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