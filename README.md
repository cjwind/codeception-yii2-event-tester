# Yii2EventTester

[![Build Status](https://travis-ci.com/cjwind/codeception-yii2-event-tester.svg?branch=master)](https://travis-ci.com/cjwind/codeception-yii2-event-tester)

Codeception module which test whether yii2 event is triggered.

## Installation

```
$ composer require cjwind/codeception-yii2-event-tester
```

## Usage

### Configure

Enable module in suite configuration. For example, enable module in `unit.suite.yml`:

```yml
class_name: UnitTester
modules:
    enabled:
      - Asserts
      - Yii2:
            part: [orm, email, fixtures]
      - cjwind\Yii2EventTester\Yii2EventTester
```

### Use in test

```php
namespace tests\unit\models;

use app\models\EventTestedClass;

class EventTestedClassTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testEventTrigger() {
        $obj = new EventTestedClass;
        $this->tester->assertEventTriggered($obj, EventTestedClass::EVENT_FOO, function() use ($obj) {
            $obj->bar();    // Function should trigger event
        });

        $this->tester->assertEventTriggered(EventTestedClass::class, EventTestedClass::EVENT_BAR, function() {
            // Do sth. should trigger EventTestedClass::EVENT_BAR
        });
    }
}
```

## Class-level Event

Because object's [trigger()](https://www.yiiframework.com/doc/api/2.0/yii-base-component#trigger()-detail) also invokes class-level handler, trigger assertion of class-level event will pass when the event is triggered by an object.

### License

MIT