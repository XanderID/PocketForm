# ModalForm Documentation

## Overview

<a href="https://drive.google.com/file/d/1_e2S28ElWI0lVVSfbE9m6qvY4Ng9tKNH/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/modal-form.jpg" width="50%" height="50%" />
</a>

**ModalForm** displays a dialog that prompts the player to either confirm or cancel an action. It features two customizable buttons—one for submitting (confirming) and one for canceling. This form type is ideal for critical operations such as confirming "Are you sure you want to delete user data?" before proceeding.

---

## Using the Helper

The `PocketFormHelper::confirm` method allows you to quickly create a ModalForm. This helper abstracts away most of the setup so you can focus on your business logic.

### Example Using the Helper

```php
use XanderID\PocketForm\modal\ModalFormResponse;
use XanderID\PocketForm\PocketFormHelper;
use pocketmine\player\Player;

// Create a confirmation dialog using the helper method.
$form = PocketFormHelper::confirm(
    'Confirm Action', // Form title.
    'Are you sure you want to delete the user data?', // Form content.
    function (ModalFormResponse $response): void {
        /** @var Player $player */
        $player = $response->getPlayer();
        // Retrieve the player's choice: true means confirmed, false means cancelled.
        $isConfirmed = $response->getChoice();
        if ($isConfirmed) {
            $player->sendMessage('User data has been deleted.');
        } else {
            $player->sendMessage('Deletion cancelled.');
        }
    },
    'Yes, delete', // Custom text for the confirm button (optional).
    'No, cancel'   // Custom text for the cancel button (optional).
);

// Send the form to the player.
$player->sendForm($form);
```

---

## Using Instance

For more control over the form's configuration, you can directly instantiate a ModalForm and manually set its properties.

### Example Using Instance

```php
use XanderID\PocketForm\modal\ModalForm;
use XanderID\PocketForm\modal\ModalFormResponse;
use pocketmine\player\Player;

// Create a new ModalForm instance with a title.
$form = new ModalForm('Confirm Action');

// Set the form content and customize button texts.
$form->setBody('Are you sure you want to delete the user data?');
$form->setSubmit('Yes, delete'); // Confirm button text.
$form->setCancel('No, cancel');  // Cancel button text.

// Define a response listener to handle the player's selection.
$form->onResponse(function (ModalFormResponse $response): void {
    /** @var Player $player */
    $player = $response->getPlayer();
    $isConfirmed = $response->getChoice(); // Get the player's choice.
    if ($isConfirmed) {
        $player->sendMessage('User data has been deleted.');
    } else {
        $player->sendMessage('Deletion cancelled.');
    }
});

// Send the form to the player.
$player->sendForm($form);
```
