<?php
namespace GuzzleHttp\Tests\Subscriber\LogSubscriber;

use GuzzleHttp\Subscriber\Log\SimpleLogger;

/**
 * @covers GuzzleHttp\Subscriber\Log\SimpleLogger
 */
class SimpleLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogsToFopen()
    {
        $resource = fopen('php://temp', 'r+');
        $logger = new SimpleLogger($resource);
        $logger->log('WARN', 'Test {key}', array('key' => 'value'));
        rewind($resource);
        $this->assertEquals("[WARN] Test value\n", stream_get_contents($resource));
        fclose($resource);
    }

    public function testLogsToCallable()
    {
        $called = false;
        $c = function ($message) use (&$called) {
            $this->assertEquals("[WARN] Test value\n", $message);
            $called = true;
        };
        $logger = new SimpleLogger($c);
        $logger->log('WARN', 'Test {key}', array('key' => 'value'));
        $this->assertTrue($called);
    }

    public function testLogsWithEcho()
    {
        ob_start();
        $logger = new SimpleLogger();
        $logger->log('WARN', 'Test {key}', array('key' => 'value'));
        $result = ob_get_clean();
        $this->assertEquals("[WARN] Test value\n", $result);
    }
}
