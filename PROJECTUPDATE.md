Please update the input validation behavior.

Current issue:
The form input is too restrictive or not validating correctly.

Required changes:

1. The input field should still allow the user to type anything temporarily, including letters.
2. Validation must happen after input/submission.
3. If the value is expected to be a number, it must:
    - be an integer only
    - not contain letters
    - not be empty
    - not be negative
    - not exceed 999999999999
4. If the user enters invalid input, show a clear validation error message.
5. Do not silently convert invalid text into 0 or another default value.
6. Keep the existing default behavior and UI structure unless changes are required for validation.
7. Apply validation on both frontend and backend if possible.
8. Or in form make the max character is 12, only accept number.

Expected rule:
Valid examples:

- 1
- 100
- 999999999999

Invalid examples:

- abc
- 12abc
- -5
- 1.5
- empty input
- 1000000000000

Use max value: 999999999999.
