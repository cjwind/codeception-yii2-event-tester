<?php
namespace cjwind\Yii2EventTester;

class Yii2EventTester extends \Codeception\Module {
    /**
     * Assert whether event is triggerd.
     *
     * @param [mixed] $mixed Object or class name.
     * @param [string] $eventName
     * @param [callable] $testedFunction Do something should trigger event in this function.
     */
    public function assertEventTriggered($mixed, $eventName, $testedFunction) {
        $checker = new EventChecker;

        if (!$checker->isEventTriggered($mixed, $eventName, $testedFunction)) {
            \PHPUnit_Framework_Assert::fail('Event ' . $eventName . ' should be triggered.');
        }
    }
}