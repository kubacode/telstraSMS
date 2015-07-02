<?php
require dirname(__FILE__) . '/../Vendor/autoload.php';
class telstraSMSTest extends PHPUnit_Framework_TestCase
{

    public function testAttribues()
    {
        $this->assertClassHasAttribute('client', 'kubacode\telstraSMS\telstraSMS');
        $this->assertClassHasAttribute('clientID', 'kubacode\telstraSMS\telstraSMS');
        $this->assertClassHasAttribute('clientSecret', 'kubacode\telstraSMS\telstraSMS');
        $this->assertClassHasAttribute('accessToken', 'kubacode\telstraSMS\telstraSMS');
    }

    public function testSend()
    {
        $message = new kubacode\telstraSMS\telstraSMS(getenv('SMS_API_KEY'),getenv('SMS_API_SECRET'));
        $sentMessage = $message->send(getenv('TEST_MOBILE_NUMBER'), 'test');
        $this->assertObjectHasAttribute('messageId',$sentMessage);

        $messageData = new stdClass();
        $messageData->message = $message;
        $messageData->sentMessage = $sentMessage;

        return $messageData;
    }

    /**
     * @depends testSend
     */
    public function testStatus($messageData)
    {
        $message = $messageData->message;
        $sentMessage = $messageData->sentMessage;
        $messageStatus = $message->getStatus($sentMessage->messageId);

        $this->assertObjectHasAttribute('sentTimestamp',$messageStatus);
    }

    /**
     * @depends testSend
     */
    public function testResponse($messageData)
    {
        $message = $messageData->message;
        $sentMessage = $messageData->sentMessage;
        $messageResponse = $message->getResponse($sentMessage->messageId)[0];

        $this->assertObjectHasAttribute('from',$messageResponse);
    }
}
