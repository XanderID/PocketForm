# Confirmation Documentation

## Overview

**Confirmation** allows you to attach a modal dialog to a button or form element. When the user interacts with the element, the confirmation dialog appears, prompting the user to verify their choice. This feature is particularly useful for critical actions—such as deleting data, resetting settings, or performing any irreversible operation.

---

## Using Confirmation in SimpleForm

<a href="https://drive.google.com/file/d/1_Zp3SlYQkZFpAxp2bhIET7F2DxiTdEKJ/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/simple-confirm.jpg" width="50%" height="50%" />
</a>

Enhance SimpleForm buttons with confirmation dialogs by using the `confirm` method on a Button element. When a button with confirmation is clicked, the player is prompted to confirm the action. The action is only executed if the confirmation is accepted.

### Example: SimpleForm with Button Confirmation

```php
use XanderID\PocketForm\simple\SimpleForm;
use XanderID\PocketForm\simple\element\Button;
use XanderID\PocketForm\simple\SimpleFormResponse;
use pocketmine\player\Player;

// Create a SimpleForm instance.
$form = new SimpleForm('Main Menu');
$form->setBody('Please select an option:');

// Create a button and attach a confirmation dialog.
$deleteButton = new Button('Delete Account');
// Attach confirmation message to the button.
$deleteButton->confirm('Are you sure you want to delete your account?');

// Add the button to the form.
$form->addElement($deleteButton);

// Set a response listener to handle button selections.
$form->onResponse(function(SimpleFormResponse $response): void {
    $player = $response->getPlayer();
    $selected = $response->getSelected();
    // Process the selected button's action.
    $player->sendMessage('You have selected: ' . $selected->getId());
});

// Send the form to the player.
$player->sendForm($form);
```

In this example, clicking the "Delete Account" button will display a confirmation dialog. Only if the player confirms will the associated action (such as account deletion) be processed.

---

## Using Confirmation in CustomForm

<a href="https://drive.google.com/file/d/1_ldzlQGO3JbYczwaCfZ31gbtHfZ6HtJ1/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/custom-confirm.jpg" width="50%" height="50%" />
</a>

You can also attach confirmation dialogs in CustomForms. This is useful when you want to ensure users verify their input or actions—especially when dealing with sensitive data or critical settings.

### Example: CustomForm with Element Confirmation

```php
use XanderID\PocketForm\custom\CustomForm;
use XanderID\PocketForm\custom\CustomFormResponse;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Toggle;
use pocketmine\player\Player;

// Create a CustomForm instance.
$form = new CustomForm('Settings');

// Add an input element for the username.
$input = new Input('Enter new username', 'Your username here', 'JohnDoe');
$form->addElement($input);

// Optionally add more elements, e.g. a toggle for notifications.
$form->addElement(new Toggle('Enable notifications', true));

// Attach a confirmation dialog to the form.
// This confirmation will be shown when the user submits the form.
$form->confirm('Are you sure you want to change your username?');

// Set a response listener to handle form submission.
$form->onResponse(function(CustomFormResponse $response): void {
    $player = $response->getPlayer();
    // Use array destructuring to retrieve the response values.
    [$username, $notifications] = $response->getValues();
    $player->sendMessage('Settings updated. New username: ' . $username);
});

// Send the form to the player.
$player->sendForm($form);
```

In this CustomForm example, the confirmation dialog is triggered when the form is submitted. This extra step ensures that the user intentionally confirms the change—helping to prevent accidental modifications.
