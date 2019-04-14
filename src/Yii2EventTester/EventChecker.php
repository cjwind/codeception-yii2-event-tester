<?php
namespace cjwind\Yii2EventTester;

class EventChecker {
    public function isEventTriggered($mixed, $eventName, $testedFunction) {
        $type = gettype($mixed);

        if ($type == 'string') {
            return $this->isClassEventTriggered($mixed, $eventName, $testedFunction);
        }
        else if ($type == 'object') {
            return $this->isObjectEventTriggered($mixed, $eventName, $testedFunction);
        }
        else {
            throw new \Exception('$mixed should be object or class name.');
        }
    }

    private function isClassEventTriggered($class, $eventName, $testedFunction) {
        $called = false;
        $handler = function ($event) use (&$called) {
            $called = true;
        };

        \yii\base\Event::on($class, $eventName, $handler);
        $testedFunction();
        \yii\base\Event::off($class, $eventName, $handler);

        return $called;
    }

    private function isObjectEventTriggered($object, $eventName, $testedFunction) {
        $called = false;
        $handler = function ($event) use (&$called) {
            $called = true;
        };

        $object->on($eventName, $handler);
        $testedFunction();
        $object->off($eventName, $handler);

        return $called;
    }
}