# SimpleForm Documentation

## Overview

<a href="https://drive.google.com/file/d/1_UqIbM1BXtAT9OZW3Moi_2IayeIw_THW/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/simple-menu.jpg" width="50%" height="50%" />
</a>

**SimpleForm** is crafted to build straightforward menu-based interfaces where players choose an option from a list of buttons. It is perfect for main menus, quick selections, and simple navigation. With SimpleForm, you can quickly set up an options list and process the player's choice with minimal code.

---

## Using the Helper

PocketForm provides the `PocketFormHelper::menu` method to simplify the creation of SimpleForms by handling much of the boilerplate code.

### Example Using the Helper

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\simple\SimpleFormResponse;
use pocketmine\player\Player;

$form = PocketFormHelper::menu(
    'Main Menu',                     // Form title
    'Please select an option:',      // Form content or description
    ['Play', 'Settings', 'Exit'],    // List of button options
    function (SimpleFormResponse $response): void {
        $player = $response->getPlayer();
        $selected = $response->getSelected(); // Get the selected button
        $player->sendMessage('You have selected: ' . $selected->getId());
    }
);

// Send the form to the player.
$player->sendForm($form);
```

### Example Using Callable Builder

If your form options redirect to various functions, you can simplify the callbacks with the Callable Builder:

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\Utils;
use pocketmine\player\Player;

public function serverList(Player $player): void {
    $player->sendMessage('Welcome to the Server List');
}

public function serverSettings(Player $player): void {
    $player->sendMessage('Welcome to Server Settings');
}

$form = PocketFormHelper::menu(
    'Main Menu',                      // Form title
    'Please select an option:',       // Form content
    ['Play', 'Settings', 'Exit'],     // List of button options
    Utils::createMenuCall([
        fn(Player $player) => $this->serverList($player),
        fn(Player $player) => $this->serverSettings($player)
        // No callback is assigned for 'Exit'
    ])
);

// Send the form to the player.
$player->sendForm($form);
```

---

## Creating a SimpleForm Instance

For greater control, you can instantiate a SimpleForm directly and add button elements manually.

### Example Using Instance Creation

```php
use XanderID\PocketForm\simple\SimpleForm;
use XanderID\PocketForm\simple\SimpleFormResponse;
use XanderID\PocketForm\simple\element\Button;
use XanderID\PocketForm\simple\element\ButtonImage;
use pocketmine\player\Player;

$form = new SimpleForm('Main Menu');
$form->setBody('Please select an option:');

// Add a button without an image.
$trashButton = new Button('Trash');
$form->addElement($trashButton);

// Add a button with an image.
$diamondSwordButton = new Button('Diamond Sword', ButtonImage::path('textures/items/diamond_sword'));
$form->addElement($diamondSwordButton);

// Add a button with an onClick listener.
$appleButton = new Button('Apple', ButtonImage::path('textures/items/apple'));
$appleButton->onClick(function(Player $player): void {
    $player->sendMessage("I really like Apples!");
});
$form->addElement($appleButton);

// Set a response listener to handle button selections (for buttons without onClick).
$form->onResponse(function(SimpleFormResponse $response): void {
    $player = $response->getPlayer();
    $selected = $response->getSelected();
    $player->sendMessage('You have selected: ' . $selected->getId());
});

$player->sendForm($form);
```

---

## Using Legacy Methods

For legacy codebases, you can still create a SimpleForm by using the older methods like `addButton` and `addButtons`.

### Example Using Legacy Methods

```php
use XanderID\PocketForm\simple\SimpleForm;
use XanderID\PocketForm\simple\SimpleFormResponse;
use pocketmine\player\Player;

$form = new SimpleForm('Main Menu');
$form->setBody('Please select an option:');

// Add a single button without an image.
$form->addButton('Trash');

// Add a single button with an image.
$form->addButton('Diamond Sword', 0, 'textures/items/diamond_sword');

// Add multiple buttons at once.
$form->addButtons(['Apple', 'Obsidian']);

$form->onResponse(function(SimpleFormResponse $response): void {
    $player = $response->getPlayer();
    $selected = $response->getSelected();
    $player->sendMessage('You have selected: ' . $selected->getId());
});

$player->sendForm($form);
```