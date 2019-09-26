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
        yield ['/ticket', 'GET', '200'];
        yield ['/identification', 'GET', '404'];
        yield ['/recap', 'GET', '404'];
        yield ['/confirmation', 'GET', '404'];

    }

    public function testAddNewBooking()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/ticket');

        //ticket
        $form = $crawler->selectButton('Valider')->form();
        $form['form_step_one[visitDate][month]'] = "12";
        $form['form_step_one[visitDate][day]'] = "2";
        $form['form_step_one[visitDate][year]'] = "2019";
        $form['form_step_one[ticketNumber]'] = "2";
        $form['form_step_one[email]'] = "toto@gmail.com";

        $client->submit($form);
       $crawler = $client->followRedirect();
       $this->assertSame(2, $crawler->filter('label:contains("First name")')->count());

       //Identification
        $form = $crawler->selectButton('Valider')->form();
        $values =$form->getPhpValues();
        $values['show_ticket']['tickets'][0]['firstName'] = "Bayram";
        $values['show_ticket']['tickets'][0]['lastName'] = "KILIC";
        $values['show_ticket']['tickets'][0]['country'] = "FR";
        $values['show_ticket']['tickets'][0]['birthdate']['month'] = "1";
        $values['show_ticket']['tickets'][0]['birthdate']['day'] = "1";
        $values['show_ticket']['tickets'][0]['birthdate']['year'] = "1988";
        $values['show_ticket']['tickets'][0]['reduction'] = "1";

        $values['show_ticket']['tickets'][1]['firstName'] = "Bayram";
        $values['show_ticket']['tickets'][1]['lastName'] = "KILIC";
        $values['show_ticket']['tickets'][1]['country'] = "FR";
        $values['show_ticket']['tickets'][1]['birthdate']['month'] = "1";
        $values['show_ticket']['tickets'][1]['birthdate']['day'] = "1";
        $values['show_ticket']['tickets'][1]['birthdate']['year'] = "1988";
        $values['show_ticket']['tickets'][1]['reduction'] = "1";

        $client->request('POST', $form->getUri(), $values, $form->getPhpValues());
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

    }
}