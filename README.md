# PocketForm

PocketForm is a powerful and flexible PHP library designed exclusively for creating interactive forms for [PocketMine-MP](https://github.com/pmmp/PocketMine-MP). With an intuitive API and a modular architecture, PocketForm allows developers to easily build various types of forms—ranging from simple button menus to complex custom forms with dynamic validation and interactive elements—tailored for PocketMine environments.

## Table of Contents

- [PocketForm](#pocketform)
  - [Table of Contents](#table-of-contents)
  - [Features](#features)
  - [Installation](#installation)
  - [Getting Started](#getting-started)
  - [Usage Examples](#usage-examples)
    - [Creating a Simple Menu Form](#creating-a-simple-menu-form)
    - [Wiki](#wiki)

## Features

- **Multiple Form Types:**  
  Create various form types including simple, custom, and modal forms.
- **Dynamic Form Elements:**  
  Add interactive elements such as inputs, dropdowns, sliders, step sliders, toggles, and labels.
- **Custom Validation:**  
  Use built-in validators or define your own using closures.
- **Event Handling:**  
  Easily attach callback functions for response handling (`onResponse`), form closing (`onClose`), and button clicks (`onClick`).
- **Extensible Architecture:**  
  Leverage traits and a modular design to extend and customize the library.

## Installation

To install **PocketForm**, use Composer:

```bash
composer require xanderid/pocketform
```

Alternatively, clone or download the repository:

```bash
git clone https://github.com/XanderID/PocketForm.git
```

## Getting Started

After installation, you can start creating forms immediately. PocketForm provides helper classes and traits that simplify form creation, element management, and response handling.

## Usage Examples

### Creating a Simple Menu Form

The SimpleForm is ideal for creating menu-based interfaces where the player selects from a list of buttons.

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\simple\SimpleFormResponse;

// Create a simple menu form with a title, body, and button options.
$form = PocketFormHelper::menu(
    'Main Menu',
    'Please select an option:',
    ['Play', 'Settings', 'Exit'],
    function (SimpleFormResponse $response) {
        $player = $response->getPlayer();
        // Process button selection using $response->getSelected()
    }
);

// Send the form to the player.
$player->sendForm($form);
```

Or you can use the Callable Builder:

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\Utils;
use pocketmine\player\Player;

$form = PocketFormHelper::menu(
    'Main Menu',
    'Please select an option:',
    ['Play', 'Settings', 'Exit'],
    Utils::createMenuCall([
        fn(Player $player) => $this->serverList($player),
        fn(Player $player) => $this->serverSettings($player)
    ])
);

// Send the form to the player.
$player->sendForm($form);
```

### Wiki

For additional documentation, please follow [this link](https://github.com/XanderID/PocketForm/wiki).
