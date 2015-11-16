<?php

/**
 * TotalReup (r) Payment Center (https://www.totalreup.com)
 *
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @author    Total Developer Team <developer@totalreup.com>
 * @copyright 2015 Copyright(c) Total Mobile (https://totalmobile.com) - All rights reserved.
 */

namespace Toplib\GenericApi\Tests\Client;

use GuzzleHttp\Cookie\CookieJar;
use Toplib\GenericApi\Client\HttpRequest;

class HttpRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new HttpRequest('get', '/local', []);
    }

    public function testConstructor()
    {
        $method = 'get';
        $url = '/local';
        $options = ['body' => '{}'];
        $request = new HttpRequest($method, $url, $options);
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($url, $request->getUrl());
        $this->assertEquals($options, $request->getOptions());
    }

    public function testSend()
    {
        $this->setExpectedException('GuzzleHttp\Exception\RequestException');
        $this->request->send();
    }

    public function testMethod()
    {
        $this->request->setMethod('post');
        $this->assertEquals('post', $this->request->getMethod());
    }

    public function testUtl()
    {
        $this->request->setUrl('/');
        $this->assertEquals('/', $this->request->getUrl());
    }

    public function testBody()
    {
        $this->assertNull($this->request->getBody());
        $this->request->setBody('test');
        $this->assertEquals('test', $this->request->getBody());
        $this->assertEquals('test', $this->request->getOptions()['body']);
    }

    public function testSetXML()
    {
        $xml = '<article></article>';
        $this->request->setXML($xml);
        $this->assertEquals($xml, $this->request->getBody());
        $this->assertEquals('text/xml; charset=utf-8', $this->request->getHeader('Content-Type'));
    }

    public function testSetHeaders()
    {
        $this->request->setHeaders(['Content-Type' => 'text/html']);
        $this->assertEquals('text/html', $this->request->getHeader('Content-Type'));
        $this->assertEquals(['Content-Type' => 'text/html'], $this->request->getHeaders());
    }

    public function testAddHeader()
    {
        $this->request->addHeader('Content-Type', 'text/html');
        $this->request->addHeader('X-Requested-With', 'XMLHttpRequest');
        $this->assertEquals('text/html', $this->request->getHeader('Content-Type'));
        $this->assertEquals('XMLHttpRequest', $this->request->getHeader('X-Requested-With'));
    }


    public function testOptions()
    {
        $xml = '<article></article>';
        $this->request->setOptions(['body' => $xml]);
        $this->assertEquals($xml, $this->request->getOptions()['body']);
    }

    public function testSetSSLKey()
    {
        $this->request->setSSLKey('certificate');
        $this->assertEquals('certificate', $this->request->getOptions()['ssl_key']);

        $this->request->setSSLKey('certificate', 'password');
        $this->assertEquals(['certificate', 'password'], $this->request->getOptions()['ssl_key']);
    }

    public function testSetCertificate()
    {
        $this->request->setCertificate('certificate');
        $this->assertEquals('certificate', $this->request->getOptions()['cert']);

        $this->request->setCertificate(['certificate', 'password']);
        $this->assertEquals(['certificate', 'password'], $this->request->getOptions()['cert']);
    }

    public function testSetCurlOption()
    {
        $this->request->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->assertFalse($this->request->getOptions()['config']['curl'][CURLOPT_SSL_VERIFYPEER]);

        $this->request->setCurlOption(CURLOPT_SSL_VERIFYPEER, true);
        $this->assertTrue($this->request->getOptions()['config']['curl'][CURLOPT_SSL_VERIFYPEER]);
    }

    public function testQuery()
    {
        $query = ['user' => 1];
        $this->request->setQuery($query);
        $this->assertEquals($query, $this->request->getOptions()['query']);

        $this->request->addQuery('q', 'test');
        $this->assertEquals('test', $this->request->getOptions()['query']['q']);
        $this->assertEquals(1, $this->request->getOptions()['query']['user']);
    }

    public function testSetCookies()
    {
        $cookie = new CookieJar();
        $this->request->setCookies($cookie);
        $this->assertEquals($cookie, $this->request->getOptions()['cookies']);
    }

    public function testSetDebug()
    {
        $this->request->setDebug(true);
        $this->assertTrue($this->request->getOptions()['debug']);

        $this->request->setDebug(false);
        $this->assertFalse($this->request->getOptions()['debug']);
    }

    public function testSetDecodeContent()
    {
        $this->request->setDecodeContent('gzip');
        $this->assertEquals('gzip', $this->request->getOptions()['decode_content']);
    }

    public function testSetExpect()
    {
        $this->request->setExpect('201');
        $this->assertEquals('201', $this->request->getOptions()['expect']);
    }

    public function testSetFormParams()
    {
        $this->request->setFormParams(['user' => 1]);
        $this->assertEquals(['user' => 1], $this->request->getOptions()['body']);
        $this->assertEquals('application/x-www-form-urlencoded', $this->request->getHeader('Content-Type'));
    }

    public function testSetConnectionTimeOut()
    {
        $this->request->setConnectTimeOut(30);
        $this->assertEquals(30, $this->request->getOptions()['connect_timeout']);
    }

    public function testSetTimeOut()
    {
        $this->request->setTimeOut(30);
        $this->assertEquals(30, $this->request->getOptions()['timeout']);
    }

    public function testSetHttpErrors()
    {
        $this->request->setHttpErrors(true);
        $this->assertTrue($this->request->getOptions()['exceptions']);

        $this->request->setHttpErrors(false);
        $this->assertFalse($this->request->getOptions()['exceptions']);
    }

    public function testSetJson()
    {
        $this->request->setJson('{"id":1}');
        $this->assertEquals('{"id":1}', $this->request->getOptions()['json']);
    }

    public function testSetVersion()
    {
        $this->request->setVersion('http1');
        $this->assertEquals('http1', $this->request->getOptions()['version']);
    }

    public function testAllowRedirects()
    {
        $this->request->allowRedirects(true);
        $this->assertTrue($this->request->getOptions()['allow_redirects']);

        $this->request->allowRedirects(false);
        $this->assertFalse($this->request->getOptions()['allow_redirects']);
    }

    public function testSetStream()
    {
        $this->request->setStream(true);
        $this->assertTrue($this->request->getOptions()['stream']);

        $this->request->setStream(false);
        $this->assertFalse($this->request->getOptions()['stream']);
    }

    public function testSSLVerification()
    {
        $this->request->SSLVerification(true);
        $this->assertTrue($this->request->getOptions()['verify']);

        $this->request->SSLVerification(false);
        $this->assertFalse($this->request->getOptions()['verify']);
    }

    public function testSaveTo()
    {
        $this->request->saveTo('/var/response');
        $this->assertEquals('/var/response', $this->request->getOptions()['save_to']);
    }

    public function testSetSubscribers()
    {
        $this->request->setSubscribers(['subscriber']);
        $this->assertEquals(['subscriber'], $this->request->getOptions()['subscribers']);
    }

    public function testAttachEventListener()
    {
        $this->request->attachEventListener('before', [$this, 'testAttachEventListener']);
        $this->assertEquals(['before' => [[$this, 'testAttachEventListener']]], $this->request->getOptions()['events']);

        $this->request->attachEventListener('complete', [$this, 'testAttachEventListener'], '200', false);
        $this->assertEquals(
            [
                'before' => [
                    [$this, 'testAttachEventListener']
                ],
                'complete' => [
                    [
                        'fn' => [$this, 'testAttachEventListener'],
                        'priority' => 200,
                        'once' => false,
                    ]
                ]
            ], $this->request->getOptions()['events']
        );
    }

    public function testSetProxy()
    {
        $this->request->setProxy('127.0.0.1', 8080, 'username', 'password');
        $this->assertEquals('http://username:password@127.0.0.1:8080', $this->request->getOptions()['proxy']);

        $this->request->setProxy('127.0.0.1', 8080);
        $this->assertEquals('http://127.0.0.1:8080', $this->request->getOptions()['proxy']);

        $this->request->setProxy('http://username:password@127.0.0.1:8080');
        $this->assertEquals('http://username:password@127.0.0.1:8080', $this->request->getOptions()['proxy']);
    }

    public function testSetAuth()
    {
        $this->request->setAuth('username', 'password', 'digest');
        $this->assertEquals(['username', 'password', 'digest'], $this->request->getOptions()['auth']);
    }
}
