<?php

namespace tests\Antevenio\Tests\CountryBundle;
use Silex\Application;
use Silex\WebTestCase;

class CountryControllerTest extends WebTestCase {

    public function createApplication() {
        return require __DIR__.'/../../../../app/app_test.php';
    }

    public function setUp()
    {
        parent::setUp();
        $this->cleanDb();
    }

    public function testGetAll()
    {
        $data = $this->tryApiCall('GET','/api/v1/countries');
        $expected =  array(
            array('id'=>1, 'name'=>'España','code'=>'ES'),
            array('id'=>2, 'name'=>'Italia','code'=>'IT'),
            array('id'=>3, 'name'=>'Francia','code'=>'FR')
        );
        $this->assertSame($expected, $data);
    }

    public function testGet()
    {
        $this->tryWrongApiCall('GET','/api/v1/countries/111');

        $data   = $this->tryApiCall('GET','/api/v1/countries/1');
        $expected =  array('id'=>1, 'name'=>'España','code'=>'ES');
        $this->assertSame($expected, $data);
    }

    public function testPost()
    {
        $countryName = 'Alemania';
        $countryCode = 'DE';

        $this->tryWrongApiCall('POST','/api/v1/countries', array('countryyy'=>array('name'=>$countryName,'code'=>$countryCode)));

        $this->tryApiCall('POST','/api/v1/countries', array('country'=>array('name'=>$countryName,'code'=>$countryCode)));

        $data   = $this->tryApiCall('GET','/api/v1/countries');
        $expected =  array(
            array('id'=>1, 'name'=>'España','code'=>'ES'),
            array('id'=>2, 'name'=>'Italia','code'=>'IT'),
            array('id'=>3, 'name'=>'Francia','code'=>'FR'),
            array('id'=>4, 'name'=>'Alemania','code'=>'DE')
        );

        $this->assertSame($expected, $data);
    }

    public function testPut()
    {
        $countryId   = 1;
        $countryName = 'Spain';
        $countryCode = 'ES1';

        $this->tryWrongApiCall('PUT','/api/v1/countries', array('country'=>array('id'=>'A','name'=>$countryName,'code'=>$countryCode)));

        $this->tryApiCall('PUT','/api/v1/countries', array('country'=>array('id'=>$countryId,'name'=>$countryName,'code'=>$countryCode)));

        $data   = $this->tryApiCall('GET','/api/v1/countries');
        $expected =  array(
            array('id'=>1, 'name'=>'Spain','code'=>'ES1'),
            array('id'=>2, 'name'=>'Italia','code'=>'IT'),
            array('id'=>3, 'name'=>'Francia','code'=>'FR')
        );

        $this->assertSame($expected, $data);
    }

    public function testDelete()
    {
        $countryId = 1;

        $this->tryWrongApiCall('DELETE','/api/v1/countries', array('id'=>'a'));

        $this->tryApiCall('DELETE','/api/v1/countries', array('id'=>$countryId));

        $data   = $this->tryApiCall('GET','/api/v1/countries');
        $expected =  array(
            array('id'=>2, 'name'=>'Italia','code'=>'IT'),
            array('id'=>3, 'name'=>'Francia','code'=>'FR')
        );

        $this->assertSame($expected, $data);
    }

    protected function tryApiCall($method = 'GET', $url = '/', $params = array() )
    {
        $client = static::createClient();
        $client->request($method, $url,$params);
        $response = $client->getResponse();

        switch($method)
        {
            case 'POST':
                $this->assertResponseStatusCode($response,'201');
                break;
            case 'PUT':
                $this->assertResponseStatusCode($response,'204');
                break;
            case 'DELETE':
                $this->assertResponseStatusCode($response,'200');
                break;
            default:
                $this->isApplicationJson($response);
                break;
        }

        return json_decode($response->getContent(), TRUE);
    }

    protected function tryWrongApiCall($method = 'GET', $url = '/', $params = array() )
    {
        $client = static::createClient();
        $client->request($method, $url,$params);
        $response = $client->getResponse();

        switch($method)
        {
            case 'POST':
                $this->assertNotEquals('201',$response->getStatusCode());
                break;
            case 'PUT':
                $this->assertNotEquals('204',$response->getStatusCode());
                break;
            default:
                $this->assertNotEquals('200',$response->getStatusCode());
                break;
        }
    }

    public function assertResponseStatusCode($response, $code){
        // Assert that the post redirects us to the /countries/id page
        $this->assertEquals(
            $code,
            $response->getStatusCode()
        );

    }

    public function isApplicationJson($response){
        // Assert that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

    }

    private function cleanDb()
    {
        $app = $this->createApplication();

        $app['db']->exec('TRUNCATE TABLE country');
        $app['db']->exec("insert into country VALUES (1, 'España','ES')");
        $app['db']->exec("insert into country VALUES (2, 'Italia','IT')");
        $app['db']->exec("insert into country VALUES (3, 'Francia','FR')");

    }

}