<?php

use PHPUnit\Framework\TestCase;

final class SenerTest extends TestCase
{

    public function testSener()
    {
        $accessKeyId = getenv('ACCESS_KEY_ID');
        $accessSec = getenv('ACCESS_SEC');
        $project = getenv('PROJECT');
        $logstore = getenv('LOGSTORE');
        echo "accessKey: $this->accessKeyId";
        echo "accessSec: $this->accessSec";
        echo "project: $this->project";
        echo "logstore: $this->logstore";

        $logItem = new Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents(array(
            "key1" => "value1",
            "key2" => "value2",
        ));
        $logitems = array($logItem);
        $client = new Aliyun_Log_Client("cn-beijing.log.aliyuncs.com", $accessKeyId, $accessSec);
        $request = new Aliyun_Log_Models_PutLogsRequest($project, $logstore, "php-test", "", $logitems);
        $response = $client->putLogs($request);
        echo $response->getHeader("x-log-requestid");
    }
}
