# Validator Documentation

## Overview

Validation in **CustomForm** ensures that user inputs meet specific criteria before the form is submitted. This process helps maintain data integrity and prevents errors during processing.

---

## Available Validators

Each **CustomForm** element can have validators applied to it. Below are the primary validators provided along with detailed usage examples.

---

### TypeValidator

<a href="https://drive.google.com/file/d/1_Ml6L8ps_lh-9hnuyW-6u1bEUrUzVDFx/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/validator-number.jpg" width="50%" height="50%" />
</a>

**Purpose:** Ensures that the input matches a specific data type (text or number).

#### Example 1: Enforcing a Numeric Input

```php
use XanderID\PocketForm\custom\validator\TypeValidator;
use XanderID\PocketForm\custom\element\Input;

// Create an input field for age.
$inputField = new Input('Enter Age:', '18');
// Apply the NUMBER type validator.
$inputField->validator(TypeValidator::NUMBER());
```

In this example, the input field is expected to receive a number. If the input is not numeric, an error message is generated.

#### Example 2: Enforcing a Text Input

```php
use XanderID\PocketForm\custom\validator\TypeValidator;
use XanderID\PocketForm\custom\element\Input;

// Create an input field for the username.
$inputField = new Input('Enter Username:', 'JohnDoe');
// Apply the TEXT type validator.
$inputField->validator(TypeValidator::TEXT());
```

Here, the input field is expected to receive text. If the input does not meet the text type criteria, it will be flagged as invalid.

---

### CustomValidator

<a href="https://drive.google.com/file/d/1_T19xUt5UaOaHA_YkBxL5YqZnb39ydJ8/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/validator-custom.jpg" width="50%" height="50%" />
</a>

**Purpose:** Allows you to create custom validation logic using a closure. This is useful for enforcing specific rules, such as disallowing banned words.

#### Example: Preventing Banned Words

```php
use XanderID\PocketForm\custom\validator\CustomValidator;
use XanderID\PocketForm\custom\element\Input;

$bannedWords = ['spam', 'scam', 'phishing'];

$validator = new CustomValidator(function($data) use ($bannedWords): ?string {
    // Check if the input contains any banned words.
    foreach ($bannedWords as $word) {
        if (stripos($data, $word) !== false) {
            // Return an error message if a banned word is found.
            return "The input contains a banned word: {$word}.";
        }
    }
    // Return null if the input is valid.
    return null;
});

// Create an input field for the username.
$inputField = new Input('Username:', 'Enter your username');
// Apply the custom validator.
$inputField->validator($validator);
```

This example checks the user input against a list of banned words. If a banned word is detected (case-insensitive), it returns a custom error message; otherwise, it returns `null`, indicating the input is valid.

---

### RegexValidator

<a href="https://drive.google.com/file/d/1_EQIQ5yE4wTjz1kO9X2_0lZx9UT0FAkW/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/validator-regex.jpg" width="50%" height="50%" />
</a>

**Purpose:** Validates input data against a specified regular expression pattern. This validator is useful for formats such as emails, phone numbers, or any custom regex-based validation.

#### Example 1: Email Validation Using Helper Method

```php
use XanderID\PocketForm\custom\validator\RegexValidator;
use XanderID\PocketForm\custom\element\Input;

// Create an input field for the email.
$emailField = new Input('Email:', 'user@example.com');
// Apply the RegexValidator for email validation using the EMAIL helper.
$emailField->validator(RegexValidator::EMAIL());
```

In this example, the `RegexValidator::EMAIL()` helper returns a validator that checks whether the input matches a valid email format.

#### Example 2: Custom Pattern Validation Using `create()`

```php
use XanderID\PocketForm\custom\validator\RegexValidator;
use XanderID\PocketForm\custom\element\Input;

// Define a custom regex pattern for validating a phone number.
$phonePattern = '/^\+?[0-9]{10,15}$/';
// Create an input field for the phone number.
$phoneField = new Input('Phone Number:', '+1234567890');
// Apply a custom regex validator.
$phoneField->validator(RegexValidator::create($phonePattern, 'Please enter a valid phone number.'));
```

This example demonstrates using the `RegexValidator::create()` method to generate a validator for a custom pattern (in this case, a phone number). If the input does not match the pattern, the provided error message is displayed.

---

### RangeValidator

<a href="https://drive.google.com/file/d/1_Ih4laaQLWTvgkkkApMLDCAZfhLI-ZGe/view?usp=drive_link">
  <img src="https://raw.githubusercontent.com/XanderID/PocketForm/refs/heads/docs/assets/validator-range.jpg" width="50%" height="50%" />
</a>

**Purpose:** Checks if the input value falls within a specified numeric range. This validator is especially useful for inputs such as age, ratings, or any numeric value with defined limits.

#### Example: Validating an Age Input

```php
use XanderID\PocketForm\custom\validator\RangeValidator;
use XanderID\PocketForm\custom\element\Input;

// Create an input field for age.
$ageField = new Input('Age:', '25');
// Apply the RangeValidator to enforce a value between 18 and 65.
$ageField->validator(new RangeValidator(18, 65));
```

If the user enters a value outside the range of 18 to 65, the validator will generate an error message like "Please enter a value between 18 and 65."

---

This documentation helps ensure that your **CustomForm** inputs are properly validated, reducing errors and maintaining data quality. Adjust the validation logic as needed to fit the specific requirements of your application.
