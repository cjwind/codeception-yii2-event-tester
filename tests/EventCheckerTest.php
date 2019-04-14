<?php
use yii\base\Event;
use yii\base\Model;
use PHPUnit\Framework\TestCase;
use cjwind\Yii2EventTester\EventChecker;

class TestedClass extends Model {
    const EVENT_FOO = 'foo';
    const EVENT_BAR = 'bar';

    public function foo() {
        $this->trigger(self::EVENT_FOO);
    }

    public static function bar() {
        Event::trigger(self::class, self::EVENT_BAR);
    }

    public function hello() {
        return 'Hello';
    }

    public static function world() {
        return 'World';
    }
}

final class EventCheckerTest extends TestCase {
    public function testIsEventTriggerWhenObjectEventTriggeredShouldReturnTrue() {
        $obj = new TestedClass;
        $checker = new EventChecker;

        $ret = $checker->isEventTriggered($obj, TestedClass::EVENT_FOO, function() use ($obj) {
            $obj->foo();
        });

        $this->assertTrue($ret);

        $ret = $checker->isEventTriggered(TestedClass::class, TestedClass::EVENT_FOO, function() use ($obj) {
            $obj->foo();    // Object trigger() also trigger class-level event.
        });

        $this->assertTrue($ret);
    }

    public function testIsEventTriggerWhenObjectEventNotTriggeredShouldReturnFalse() {
        $obj = new TestedClass;
        $checker = new EventChecker;

        $ret = $checker->isEventTriggered($obj, TestedClass::EVENT_FOO, function() use ($obj) {
            $obj->hello();
        });

        $this->assertFalse($ret);
    }

    public function testIsEventTriggerWhenClassEventTriggeredShouldReturnTrue() {
        $checker = new EventChecker;

        $ret = $checker->isEventTriggered(TestedClass::class, TestedClass::EVENT_BAR, function() {
            TestedClass::bar();
        });

        $this->assertTrue($ret);
    }

    public function testIsEventTriggerWhenClassEventNotTriggeredShouldReturnFalse() {
        $checker = new EventChecker;

        $ret = $checker->isEventTriggered(TestedClass::class, TestedClass::EVENT_BAR, function() {
            TestedClass::world();
        });

        $this->assertFalse($ret);
    }

    public function testIsEventTriggerWithArrayShouldThrowException() {
        $checker = new EventChecker;
        $this->expectException(\Exception::class);
        $checker->isEventTriggered([], 'fakeEvent', function() { });
    }
}
