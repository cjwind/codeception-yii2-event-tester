<?php
namespace cjwind\Yii2EventTester;

class Yii2EventTester extends \Codeception\Module {
    public function assertEventTriggered($mixed, $eventName, $testedFunction) {
        $checker = new EventChecker;

        if (!$checker->isEventTriggered($mixed, $eventName, $testedFunction)) {
            \PHPUnit_Framework_Assert::fail('Event ' . $eventName . ' should be triggered.');
        }
    }
}