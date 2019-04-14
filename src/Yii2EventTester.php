<?php
namespace Yii2EventTester;

class Yii2EventTester extends \Codeception\Module {
    public function assertTriggered($event, $object, $testedFunction) {
        $called = false;
        $object->on($event, function ($event) use (&$called) {
            $called = true;
        });

        $testedFunction();

        \PHPUnit_Framework_Assert::assertTrue($called, 'Event ' . $event . ' should be triggered.');
    }
}