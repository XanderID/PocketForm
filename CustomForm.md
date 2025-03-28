# CustomForm Documentation

## Overview

<a href="https://drive.google.com/file/d/1_jJHYdk_zr9yutt28WHjMg4brRw-XR1s/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/custom-form.jpg" width="50%" height="50%" />
</a>

**CustomForm** allows you to build complex, interactive forms with a rich variety of elements. It supports:

- **Input:** Text fields for user input.
- **Dropdown:** Selectable lists for choosing an option.
- **Label:** Displaying static text.
- **Slider:** Numeric selection within a defined range.
- **StepSlider:** Choosing from predefined discrete steps.
- **Toggle:** Boolean switches for on/off decisions.

CustomForm is perfect for registration forms, settings panels, or any scenario where you need to capture diverse user inputs.

---

## Using the Helper

The `PocketFormHelper::custom` method simplifies form creation by abstracting much of the setup. In the example below, multiple elements are provided as an array:

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\custom\CustomFormResponse;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Label;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use pocketmine\player\Player;

// Define form elements.
$elements = [
    // Text input element.
    new Input('Enter your name', 'Your name here', 'John Doe'),
    // Static label element.
    new Label('Please review the following information:'),
    // Dropdown element with preset options.
    new Dropdown('Select your role', ['Admin', 'User', 'Guest'], 1),
    // Slider element for numeric selection.
    new Slider('Set your volume', 0, 100, 5, 50),
    // StepSlider element for discrete choices.
    new StepSlider('Select difficulty', [1, 2, 3, 4, 5], 2),
    // Toggle element for a boolean decision.
    new Toggle('Agree to terms', false)
];

// Create a CustomForm using the helper.
$form = PocketFormHelper::custom(
    'Registration Form', // Form title.
    $elements,           // Array of form elements.
    function (CustomFormResponse $response): void {
        /** @var Player $player */
        $player = $response->getPlayer();

        // Retrieve form values using array destructuring.
        [$name, $info, $role, $volume, $difficulty, $agreed] = $response->getValues();
        $player->sendMessage('Registration complete. Your name: ' . $name);
    }
);

$form->setSubmit('Register'); // Customize the submit button text (default is 'Submit').

// Send the form to the player.
$player->sendForm($form);
```

---

## Using Instance

For greater control, you can instantiate a CustomForm directly and add each element using the `addElement()` method:

```php
use XanderID\PocketForm\custom\CustomForm;
use XanderID\PocketForm\custom\CustomFormResponse;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Label;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use pocketmine\player\Player;

$form = new CustomForm('Registration Form');
$form->setBody('Please fill in the following details:');

// Add each element individually.
$form->addElement(new Input('Enter your name', 'Your name here', 'John Doe'));
$form->addElement(new Label('Please review the following information:'));
$form->addElement(new Dropdown('Select your role', ['Admin', 'User', 'Guest'], 1));
$form->addElement(new Slider('Set your volume', 0, 100, 5, 50));
$form->addElement(new StepSlider('Select difficulty', [1, 2, 3, 4, 5], 2));
$form->addElement(new Toggle('Agree to terms', false));

$form->onResponse(function (CustomFormResponse $response): void {
    /** @var Player $player */
    $player = $response->getPlayer();

    // Extract the response values.
    [$name, $info, $role, $volume, $difficulty, $agreed] = $response->getValues();
    $player->sendMessage('Registration complete. Your name: ' . $name);
});

$form->setSubmit('Register'); // Customize the submit button text.

// Send the form to the player.
$player->sendForm($form);
```

---

## Using Instance with Legacy Methods

For projects relying on legacy code, you can still create a CustomForm by instantiating it and using older helper methods:

```php
use XanderID\PocketForm\custom\CustomForm;
use XanderID\PocketForm\custom\CustomFormResponse;
use pocketmine\player\Player;

$form = new CustomForm('Registration Form');
$form->setBody('Please fill in the following details:');

// Add elements using legacy methods.
$form->addInput('Enter your name', 'Your name here', 'John Doe');
$form->addLabel('Please review the following information:');
$form->addDropdown('Select your role', ['Admin', 'User', 'Guest'], 1);
$form->addSlider('Set your volume', 0, 100, 5, 50);
$form->addStepSlider('Select difficulty', [1, 2, 3, 4, 5], 2);
$form->addToggle('Agree to terms', false);

$form->onResponse(function (CustomFormResponse $response): void {
    /** @var Player $player */
    $player = $response->getPlayer();

    // Retrieve and process the form values.
    [$name, $info, $role, $volume, $difficulty, $agreed] = $response->getValues();
    $player->sendMessage('Registration complete. Your name: ' . $name);
});

$form->setSubmit('Register'); // Customize the submit button text.

// Send the form to the player.
$player->sendForm($form);
```
