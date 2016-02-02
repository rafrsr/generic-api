<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests\Client;

use GuzzleHttp\Cookie\CookieJar;
use Rafrsr\GenericApi\Client\RequestOptions;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;

class RequestOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestOptions
     */
    protected $options;

    public function setUp()
    {
        $this->options = new RequestOptions();
    }

    public function testConstructor()
    {
        $options = new RequestOptions([GuzzleRequestOptions::DEBUG => true]);
        $this->assertTrue($options->getAll()[GuzzleRequestOptions::DEBUG]);
    }

    public function testCreate()
    {
        $options = RequestOptions::create(
            [
                GuzzleRequestOptions::BODY => 'test',
                GuzzleRequestOptions::HEADERS => ['content' => 'html'],
            ]
        );
        $this->assertInstanceOf('Rafrsr\GenericApi\Client\RequestOptions', $options);
        $this->assertEquals('test', $options->getAll()[GuzzleRequestOptions::BODY]);
        $this->assertEquals(['content' => 'html'], $options->getAll()[GuzzleRequestOptions::HEADERS]);
    }

    public function testSetAll()
    {
        $this->assertNull($this->getOption(GuzzleRequestOptions::BODY));
        $this->options->setAll(
            [
                GuzzleRequestOptions::BODY => 'test',
                GuzzleRequestOptions::HEADERS => ['content' => 'html'],

            ]
        );
        $this->assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
        $this->assertEquals(['content' => 'html'], $this->getOption(GuzzleRequestOptions::HEADERS));
    }

    public function testBody()
    {
        $this->assertNull($this->getOption(GuzzleRequestOptions::BODY));
        $this->options->setBody('test');
        $this->assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
        $this->assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
    }

    public function testSetHeaders()
    {
        $this->options->setHeaders(['Content-Type' => 'text/html']);
        $this->assertEquals(['Content-Type' => 'text/html'], $this->getOption(GuzzleRequestOptions::HEADERS));
    }

    public function testAddHeader()
    {
        $this->options->addHeader('Content-Type', 'text/html');
        $this->options->addHeader('X-Requested-With', 'XMLHttpRequest');
        $this->assertEquals('text/html', $this->getOption(GuzzleRequestOptions::HEADERS)['Content-Type']);
        $this->assertEquals('XMLHttpRequest', $this->getOption(GuzzleRequestOptions::HEADERS)['X-Requested-With']);
    }

    public function testSetSSLKey()
    {
        $this->options->setSSLKey('certificate');
        $this->assertEquals('certificate', $this->getOption(GuzzleRequestOptions::SSL_KEY));

        $this->options->setSSLKey('certificate', 'password');
        $this->assertEquals(['certificate', 'password'], $this->getOption(GuzzleRequestOptions::SSL_KEY));
    }

    public function testSetCertificate()
    {
        $this->options->setCertificate('certificate');
        $this->assertEquals('certificate', $this->getOption(GuzzleRequestOptions::CERT));

        $this->options->setCertificate('certificate', 'password');
        $this->assertEquals(['certificate', 'password'], $this->getOption(GuzzleRequestOptions::CERT));
    }

    public function testSetCurlOption()
    {
        $this->options->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->assertFalse($this->getOption('curl')[CURLOPT_SSL_VERIFYPEER]);

        $this->options->setCurlOption(CURLOPT_SSL_VERIFYPEER, true);
        $this->assertTrue($this->getOption('curl')[CURLOPT_SSL_VERIFYPEER]);
    }

    public function testQuery()
    {
        $query = ['user' => 1];
        $this->options->setQuery($query);
        $this->assertEquals($query, $this->getOption(GuzzleRequestOptions::QUERY));

        $this->options->addQuery('q', 'test');
        $this->assertEquals('test', $this->getOption(GuzzleRequestOptions::QUERY)['q']);
        $this->assertEquals(1, $this->getOption(GuzzleRequestOptions::QUERY)['user']);
    }

    public function testSetCookies()
    {
        $cookie = new CookieJar();
        $this->options->setCookies($cookie);
        $this->assertEquals($cookie, $this->getOption(GuzzleRequestOptions::COOKIES));
    }

    public function testSetDebug()
    {
        $this->options->setDebug(true);
        $this->assertTrue($this->getOption(GuzzleRequestOptions::DEBUG));

        $this->options->setDebug(false);
        $this->assertFalse($this->getOption(GuzzleRequestOptions::DEBUG));
    }

    public function testSetDecodeContent()
    {
        $this->options->setDecodeContent('gzip');
        $this->assertEquals('gzip', $this->getOption(GuzzleRequestOptions::DECODE_CONTENT));
    }

    public function testSetExpect()
    {
        $this->options->setExpect('201');
        $this->assertEquals('201', $this->getOption(GuzzleRequestOptions::EXPECT));
    }

    public function testSetFormParams()
    {
        $this->options->setFormParams(['user' => 1]);
        $this->assertEquals(['user' => 1], $this->getOption(GuzzleRequestOptions::FORM_PARAMS));
    }

    public function testAddFormParams()
    {
        $this->options->addFormParam('user', 'username');
        $this->options->addFormParam('pass', 12345);
        $this->assertEquals(['user' => 'username', 'pass' => 12345], $this->getOption(GuzzleRequestOptions::FORM_PARAMS));
    }

    public function testSetConnectionTimeOut()
    {
        $this->options->setConnectTimeOut(30);
        $this->assertEquals(30, $this->getOption(GuzzleRequestOptions::CONNECT_TIMEOUT));
    }

    public function testSetTimeOut()
    {
        $this->options->setTimeOut(30);
        $this->assertEquals(30, $this->getOption(GuzzleRequestOptions::TIMEOUT));
    }

    public function testSetHttpErrors()
    {
        $this->options->setHttpErrors(true);
        $this->assertTrue($this->getOption(GuzzleRequestOptions::HTTP_ERRORS));

        $this->options->setHttpErrors(false);
        $this->assertFalse($this->getOption(GuzzleRequestOptions::HTTP_ERRORS));
    }

    public function testSetJson()
    {
        $this->options->setJson('{"id":1}');
        $this->assertEquals('{"id":1}', $this->getOption(GuzzleRequestOptions::JSON));
    }

    public function testSetVersion()
    {
        $this->options->setVersion('http1');
        $this->assertEquals('http1', $this->getOption(GuzzleRequestOptions::VERSION));
    }

    public function testAllowRedirects()
    {
        $this->options->allowRedirects(true);
        $this->assertTrue($this->getOption(GuzzleRequestOptions::ALLOW_REDIRECTS));

        $this->options->allowRedirects(false);
        $this->assertFalse($this->getOption(GuzzleRequestOptions::ALLOW_REDIRECTS));
    }

    public function testSetStream()
    {
        $this->options->setStream(true);
        $this->assertTrue($this->getOption(GuzzleRequestOptions::STREAM));

        $this->options->setStream(false);
        $this->assertFalse($this->getOption(GuzzleRequestOptions::STREAM));
    }

    public function testSSLVerification()
    {
        $this->options->SSLVerification(true);
        $this->assertTrue($this->getOption(GuzzleRequestOptions::VERIFY));

        $this->options->SSLVerification(false);
        $this->assertFalse($this->getOption(GuzzleRequestOptions::VERIFY));
    }

    public function testSaveTo()
    {
        $this->options->saveResponseTo('/var/response');
        $this->assertEquals('/var/response', $this->getOption(GuzzleRequestOptions::SINK));
    }

    public function testSetProxy()
    {
        $this->options->setProxy('http://username:password@127.0.0.1:8080');
        $this->assertEquals('http://username:password@127.0.0.1:8080', $this->getOption(GuzzleRequestOptions::PROXY));
    }

    public function testSetAuth()
    {
        $this->options->setAuth('username', 'password', 'digest');
        $this->assertEquals(['username', 'password', 'digest'], $this->getOption(GuzzleRequestOptions::AUTH));
    }

    public function testSetDelay()
    {
        $this->options->setDelay(15);
        $this->assertEquals(15, $this->getOption(GuzzleRequestOptions::DELAY));
    }

    public function testSetMultipart()
    {
        $this->options->setMultipart(['id' => 1]);
        $this->assertEquals(['id' => 1], $this->getOption(GuzzleRequestOptions::MULTIPART));
    }

    public function testSetSynchronous()
    {
        $this->options->setSynchronous(true);
        $this->assertEquals(true, $this->getOption(GuzzleRequestOptions::SYNCHRONOUS));

        $this->options->setSynchronous(false);
        $this->assertEquals(false, $this->getOption(GuzzleRequestOptions::SYNCHRONOUS));
    }

    public function testSetProgress()
    {
        $this->options->setProgress(
            function () {
                return 'test';
            }
        );
        $this->assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::PROGRESS)));
    }

    public function testOnHeaders()
    {
        $this->options->onHeaders(
            function () {
                return 'test';
            }
        );
        $this->assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::ON_HEADERS)));
    }

    public function testOnStats()
    {
        $this->options->onStats(
            function () {
                return 'test';
            }
        );
        $this->assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::ON_STATS)));
    }

    protected function getOption($option)
    {
        if (isset($this->options->getAll()[$option])) {
            return $this->options->getAll()[$option];
        }

        return null;
    }
}
