<?php
namespace cjwind\Yii2EventTester;

class Yii2EventTester extends \Codeception\Module {
    public function assertEventTriggered($mixed, $eventName, $testedFunction) {
        $type = gettype($mixed);

        if ($type == 'string') {
            $this->assertClassEventTriggered($mixed, $eventName, $testedFunction);
        }
        else if ($type == 'object') {
            $this->assertObjectEventTriggered($mixed, $eventName, $testedFunction);
        }
        else {
            throw new \Exception('$mixed should be object or class name.');
        }
    }

    private function assertClassEventTriggered($class, $eventName, $testedFunction) {
        $called = false;
        \yii\base\Event::on($class, $eventName, function ($event) use (&$called) {
            $called = true;
        });

        $testedFunction();

        \PHPUnit_Framework_Assert::assertTrue($called, 'Event ' . $eventName . ' of class ' . $class . ' should be triggered.');
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