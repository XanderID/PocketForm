# PocketForm Documentation

Welcome to the official documentation for **PocketForm**, a powerful PHP library designed for creating interactive forms within PocketMine-MP environments. This repository contains comprehensive guides and API references that help you integrate and use PocketForm effectively in your projects.

## Table of Contents

- [PocketForm Documentation](#pocketform-documentation)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
  - [Features Overview](#features-overview)
  - [Installation](#installation)
  - [Quick Start Guide](#quick-start-guide)
  - [Documentation Files](#documentation-files)
  - [Additional Resources](#additional-resources)
  - [License](#license)

## Introduction

PocketForm is a flexible PHP library exclusively designed to create interactive forms for PocketMine-MP servers. With its intuitive API and modular architecture, PocketForm simplifies the process of building forms—ranging from basic menus to complex custom interfaces with dynamic validation and interactive elements.

## Features Overview

- **Multiple Form Types:** Easily create simple, modal, and custom forms.
- **Dynamic Elements:** Add inputs, dropdowns, sliders, toggles, and labels to enhance interactivity.
- **Custom Validation:** Implement built-in validators or create your own using closures.
- **Event Handling:** Attach callbacks for form responses, closures, and button interactions.
- **Extensible Architecture:** Utilize traits and a modular design for further customization.

## Installation

PocketForm can be installed via Composer by adding the following to your project's `composer.json`:

```json
"require": {
    "xanderid/pocketform": "^1.0.2"
}
```

Alternatively, you can clone the repository using Git:

```bash
git clone https://github.com/XanderID/PocketForm.git
```

## Quick Start Guide

To quickly get started, you can create a simple menu form using the PocketForm helper:

```php
use XanderID\PocketForm\PocketFormHelper;
use XanderID\PocketForm\simple\SimpleFormResponse;

$form = PocketFormHelper::menu(
    'Main Menu',
    'Please choose an option:',
    ['Play', 'Settings', 'Exit'],
    function (SimpleFormResponse $response) {
        $player = $response->getPlayer();
        // Handle the player's selection here.
    }
);

$player->sendForm($form);
```

This snippet demonstrates how straightforward it is to set up a menu form. For further details and examples, please refer to the individual documentation files listed below.

## Documentation Files

This repository is organized into several key documentation files, each covering a different aspect of PocketForm:

- **[SimpleForm.md](SimpleForm.md):** Detailed instructions on implementing and using Simple Forms for basic menu interfaces.
- **[ModalForm.md](ModalForm.md):** A guide on creating Modal Forms for binary choices, such as confirmation dialogs.
- **[CustomForm.md](CustomForm.md):** Learn how to build Custom Forms that combine various interactive elements like inputs, toggles, and dropdowns.
- **[Confirmation.md](Confirmation.md):** Step-by-step guide for using Confirmation Forms to validate critical actions.
- **[Validator.md](Validator.md):** A comprehensive look at applying both built-in and custom validators to form inputs.

## Additional Resources

- **GitHub Repository:** Stay updated with the latest changes by visiting the [PocketForm GitHub page](https://github.com/XanderID/PocketForm).

## License

PocketForm is released under the MIT License. See the [LICENSE](LICENSE) file for more information.

---
I hope this documentation helps you integrate PocketForm seamlessly into your projects. For any questions or further assistance, please feel free to reach out via discord or open an issue on GitHub.
