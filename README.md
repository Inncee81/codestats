# Code::Stats
An API Client written in PHP for [Code::Stats](https://codestats.net)

howto list the level of an codestats user:
```PHP 
require_once __DIR__ . '/vendor/autoload.php'; 

use CodeStats\User;

$object = new User();
$user = $object->get("thijsbekke");

$xp = $user->getXP();
echo "user level :".  $xp->getLevel() . "<br />";
```


List all languages with their XP:
```PHP
foreach ($user->languages as $language) {
    echo "Language : " . $language->name . " <br />";
    echo "Level : " . $language->getLevel() . " <br />";
    echo "XP : " . $language->getXP() . " <br />";
}

```

List all machines with their XP:
```PHP
foreach ($user->machines as $machine) {
    echo "Machine : " . $machine->name . " <br />";
    echo "Level : " . $machine->getLevel() . " <br />";
    echo "XP : " . $machine->getXP() . " <br />";
}
```

List all XP Pulses:
```PHP
foreach ($user->history as $date => $xp) {
    echo "date : " . $date . " - " . $xp . " <br />";
}
```


##Todo

- Implement the pulse endpoint
