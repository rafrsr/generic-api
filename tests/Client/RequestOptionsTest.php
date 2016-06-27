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
        static::assertTrue($options->getAll()[GuzzleRequestOptions::DEBUG]);
    }

    public function testCreate()
    {
        $options = RequestOptions::create(
            [
                GuzzleRequestOptions::BODY => 'test',
                GuzzleRequestOptions::HEADERS => ['content' => 'html'],
            ]
        );
        static::assertInstanceOf('Rafrsr\GenericApi\Client\RequestOptions', $options);
        static::assertEquals('test', $options->getAll()[GuzzleRequestOptions::BODY]);
        static::assertEquals(['content' => 'html'], $options->getAll()[GuzzleRequestOptions::HEADERS]);
    }

    public function testSetAll()
    {
        static::assertNull($this->getOption(GuzzleRequestOptions::BODY));
        $this->options->setAll(
            [
                GuzzleRequestOptions::BODY => 'test',
                GuzzleRequestOptions::HEADERS => ['content' => 'html'],

            ]
        );
        static::assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
        static::assertEquals(['content' => 'html'], $this->getOption(GuzzleRequestOptions::HEADERS));
    }

    public function testBody()
    {
        static::assertNull($this->getOption(GuzzleRequestOptions::BODY));
        $this->options->setBody('test');
        static::assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
        static::assertEquals('test', $this->getOption(GuzzleRequestOptions::BODY));
    }

    public function testSetHeaders()
    {
        $this->options->setHeaders(['Content-Type' => 'text/html']);
        static::assertEquals(['Content-Type' => 'text/html'], $this->getOption(GuzzleRequestOptions::HEADERS));
    }

    public function testAddHeader()
    {
        $this->options->addHeader('Content-Type', 'text/html');
        $this->options->addHeader('X-Requested-With', 'XMLHttpRequest');
        static::assertEquals('text/html', $this->getOption(GuzzleRequestOptions::HEADERS)['Content-Type']);
        static::assertEquals('XMLHttpRequest', $this->getOption(GuzzleRequestOptions::HEADERS)['X-Requested-With']);
    }

    public function testSetSSLKey()
    {
        $this->options->setSSLKey('certificate');
        static::assertEquals('certificate', $this->getOption(GuzzleRequestOptions::SSL_KEY));

        $this->options->setSSLKey('certificate', 'password');
        static::assertEquals(['certificate', 'password'], $this->getOption(GuzzleRequestOptions::SSL_KEY));
    }

    public function testSetCertificate()
    {
        $this->options->setCertificate('certificate');
        static::assertEquals('certificate', $this->getOption(GuzzleRequestOptions::CERT));

        $this->options->setCertificate('certificate', 'password');
        static::assertEquals(['certificate', 'password'], $this->getOption(GuzzleRequestOptions::CERT));
    }

    public function testSetCurlOption()
    {
        $this->options->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
        static::assertFalse($this->getOption('curl')[CURLOPT_SSL_VERIFYPEER]);

        $this->options->setCurlOption(CURLOPT_SSL_VERIFYPEER, true);
        static::assertTrue($this->getOption('curl')[CURLOPT_SSL_VERIFYPEER]);
    }

    public function testQuery()
    {
        $query = ['user' => 1];
        $this->options->setQuery($query);
        static::assertEquals($query, $this->getOption(GuzzleRequestOptions::QUERY));

        $this->options->addQuery('q', 'test');
        static::assertEquals('test', $this->getOption(GuzzleRequestOptions::QUERY)['q']);
        static::assertEquals(1, $this->getOption(GuzzleRequestOptions::QUERY)['user']);
    }

    public function testSetCookies()
    {
        $cookie = new CookieJar();
        $this->options->setCookies($cookie);
        static::assertEquals($cookie, $this->getOption(GuzzleRequestOptions::COOKIES));
    }

    public function testSetDebug()
    {
        $this->options->setDebug(true);
        static::assertTrue($this->getOption(GuzzleRequestOptions::DEBUG));

        $this->options->setDebug(false);
        static::assertFalse($this->getOption(GuzzleRequestOptions::DEBUG));
    }

    public function testSetDecodeContent()
    {
        $this->options->setDecodeContent('gzip');
        static::assertEquals('gzip', $this->getOption(GuzzleRequestOptions::DECODE_CONTENT));
    }

    public function testSetExpect()
    {
        $this->options->setExpect('201');
        static::assertEquals('201', $this->getOption(GuzzleRequestOptions::EXPECT));
    }

    public function testSetFormParams()
    {
        $this->options->setFormParams(['user' => 1]);
        static::assertEquals(['user' => 1], $this->getOption(GuzzleRequestOptions::FORM_PARAMS));
    }

    public function testAddFormParams()
    {
        $this->options->addFormParam('user', 'username');
        $this->options->addFormParam('pass', 12345);
        static::assertEquals(['user' => 'username', 'pass' => 12345], $this->getOption(GuzzleRequestOptions::FORM_PARAMS));
    }

    public function testSetConnectionTimeOut()
    {
        $this->options->setConnectTimeOut(30);
        static::assertEquals(30, $this->getOption(GuzzleRequestOptions::CONNECT_TIMEOUT));
    }

    public function testSetTimeOut()
    {
        $this->options->setTimeOut(30);
        static::assertEquals(30, $this->getOption(GuzzleRequestOptions::TIMEOUT));
    }

    public function testSetHttpErrors()
    {
        $this->options->setHttpErrors(true);
        static::assertTrue($this->getOption(GuzzleRequestOptions::HTTP_ERRORS));

        $this->options->setHttpErrors(false);
        static::assertFalse($this->getOption(GuzzleRequestOptions::HTTP_ERRORS));
    }

    public function testSetJson()
    {
        $this->options->setJson('{"id":1}');
        static::assertEquals('{"id":1}', $this->getOption(GuzzleRequestOptions::JSON));
    }

    public function testSetVersion()
    {
        $this->options->setVersion('http1');
        static::assertEquals('http1', $this->getOption(GuzzleRequestOptions::VERSION));
    }

    public function testAllowRedirects()
    {
        $this->options->allowRedirects(true);
        static::assertTrue($this->getOption(GuzzleRequestOptions::ALLOW_REDIRECTS));

        $this->options->allowRedirects(false);
        static::assertFalse($this->getOption(GuzzleRequestOptions::ALLOW_REDIRECTS));
    }

    public function testSetStream()
    {
        $this->options->setStream(true);
        static::assertTrue($this->getOption(GuzzleRequestOptions::STREAM));

        $this->options->setStream(false);
        static::assertFalse($this->getOption(GuzzleRequestOptions::STREAM));
    }

    public function testSSLVerification()
    {
        $this->options->SSLVerification(true);
        static::assertTrue($this->getOption(GuzzleRequestOptions::VERIFY));

        $this->options->SSLVerification(false);
        static::assertFalse($this->getOption(GuzzleRequestOptions::VERIFY));
    }

    public function testSaveTo()
    {
        $this->options->saveResponseTo('/var/response');
        static::assertEquals('/var/response', $this->getOption(GuzzleRequestOptions::SINK));
    }

    public function testSetProxy()
    {
        $this->options->setProxy('http://username:password@127.0.0.1:8080');
        static::assertEquals('http://username:password@127.0.0.1:8080', $this->getOption(GuzzleRequestOptions::PROXY));
    }

    public function testSetAuth()
    {
        $this->options->setAuth('username', 'password', 'digest');
        static::assertEquals(['username', 'password', 'digest'], $this->getOption(GuzzleRequestOptions::AUTH));
    }

    public function testSetDelay()
    {
        $this->options->setDelay(15);
        static::assertEquals(15, $this->getOption(GuzzleRequestOptions::DELAY));
    }

    public function testSetMultipart()
    {
        $this->options->setMultipart(['id' => 1]);
        static::assertEquals(['id' => 1], $this->getOption(GuzzleRequestOptions::MULTIPART));
    }

    public function testSetSynchronous()
    {
        $this->options->setSynchronous(true);
        static::assertEquals(true, $this->getOption(GuzzleRequestOptions::SYNCHRONOUS));

        $this->options->setSynchronous(false);
        static::assertEquals(false, $this->getOption(GuzzleRequestOptions::SYNCHRONOUS));
    }

    public function testSetProgress()
    {
        $this->options->setProgress(
            function () {
                return 'test';
            }
        );
        static::assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::PROGRESS)));
    }

    public function testOnHeaders()
    {
        $this->options->onHeaders(
            function () {
                return 'test';
            }
        );
        static::assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::ON_HEADERS)));
    }

    public function testOnStats()
    {
        $this->options->onStats(
            function () {
                return 'test';
            }
        );
        static::assertEquals('test', call_user_func($this->getOption(GuzzleRequestOptions::ON_STATS)));
    }

    protected function getOption($option)
    {
        if (isset($this->options->getAll()[$option])) {
            return $this->options->getAll()[$option];
        }

        return null;
    }
}
