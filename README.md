# Yii2EventTester

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

    public function testBar() {
        $obj = new EventTestedClass;
        $this->tester->assertEventTriggered($obj, EventTestedClass::EVENT_FOO, function() use ($obj) {
            $obj->bar();    // Function should trigger event
        });
    }
}
```

### License

MIT