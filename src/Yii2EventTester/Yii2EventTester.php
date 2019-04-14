<?php
namespace cjwind\Yii2EventTester;

class Yii2EventTester extends \Codeception\Module {
    public function assertEventTriggered($object, $eventName, $testedFunction) {
        $this->assertObjectEventTriggered($object, $eventName, $testedFunction);
    }

    private function assertObjectEventTriggered($object, $eventName, $testedFunction) {
        $called = false;
        $object->on($eventName, function ($event) use (&$called) {
            $called = true;
        });

        $testedFunction();

        \PHPUnit_Framework_Assert::assertTrue($called, 'Event ' . $eventName . ' should be triggered.');
    }
}