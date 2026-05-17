# Project Update Guide — Tax Calculator UI Refinement

## Current context

The application is already working correctly. The current `calculate.blade.php` view has a functional form, validation flow, result display, Blade variables, route usage, CSRF token, and JavaScript validation. However, the visual design looks too generic / AI-generated: heavy dark gradient, glassmorphism card, oversized glow effects, overly polished icon treatment, and very synthetic spacing/color choices.

The goal is to make the page feel like a real human-made Laravel tax calculator interface for PT. XYZ, not a template demo from the void where all gradients go to retire.

## Important rule

Do **not** change the existing method, route, backend flow, validation logic, calculation logic, or variable names that already work.

Only improve the UI / Blade markup structure and Tailwind classes where needed.

## Files to focus on

- `resources/views/calculate.blade.php`
- Keep the current route/action behavior:
  - `action="{{ route('calculate.submit') }}"`
  - `method="POST"`
  - `@csrf`
- Keep the existing input name:
  - `name="income"`
- Keep the existing result variables:
  - `$taxAmount`
  - `$income`
  - `$percentage`
- Keep the existing conditional result block:
  - `@isset($taxAmount)`
- Keep or preserve the current validation behavior unless a UI adjustment requires small markup changes.

## Do not change

1. Do not rename route names.
2. Do not rename input `name="income"`.
3. Do not remove `@csrf`.
4. Do not change the form method.
5. Do not change the controller method names.
6. Do not change tax calculation formulas.
7. Do not change backend validation rules unless required to keep existing validation consistent.
8. Do not replace the app with a new framework or component system.
9. Do not introduce unnecessary packages.
10. Do not remove working JavaScript validation IDs unless you also update the JS references safely.

## UI problem to solve

The current page visually feels AI-generated because it uses:

- dramatic full-page dark gradient background
- glassmorphism card with blur and transparent borders
- glowing blue button shadow
- large decorative calculator icon
- overly rounded containers everywhere
- synthetic “dashboard demo” colors
- layout that looks beautiful but not like a practical company form

The redesigned UI should feel more grounded, simple, professional, and manually crafted.

## Design direction

Use Tailwind CSS only.

Make the page look like a practical internal PT. XYZ finance/payroll tool:

- clean background, preferably light or soft neutral
- restrained color palette
- simple card layout
- readable typography
- clear form hierarchy
- realistic spacing
- subtle border instead of glass effects
- professional button without excessive glow
- result card that feels like an official calculation summary
- small helper text where useful
- error message should be visible and readable
- responsive layout must still work well on mobile and desktop

Recommended visual style:

- Background: `bg-slate-50`, `bg-zinc-50`, or another soft neutral
- Main card: white background, normal border, subtle shadow
- Text: slate/zinc colors, strong contrast
- Accent color: blue, indigo, emerald, or neutral corporate blue
- Button: solid color, no glowing shadow
- Result section: clean summary panel/table-like layout
- Border radius: moderate, not everything needs to be `rounded-3xl`
- Avoid huge icons unless they serve the layout

## Suggested layout

Create a layout like this:

1. Top section
   - Small eyebrow text: `PT. XYZ`
   - Main title: `Kalkulator Pajak Penghasilan`
   - Short description: explain that the tool calculates employee income tax based on the applicable tax table.

2. Main card
   - Label: `Penghasilan Bruto`
   - Input with `Rp` prefix
   - Helper text: `Masukkan angka tanpa titik, koma, atau simbol.`
   - Submit button: `Hitung Pajak`

3. Error alert
   - Keep the existing session/frontend validation display behavior.
   - Make it visually clean, not neon.

4. Result section
   - Show result only when `$taxAmount` exists.
   - Use a clear calculation summary style:
     - Penghasilan
     - Tarif Pajak
     - Pajak Terutang
   - Make `Pajak Terutang` visually prominent but still professional.

5. Footer note
   - Small muted text, not too dark or hidden.

## Validation behavior to preserve

The input validation behavior should still follow these rules:

1. The input field may temporarily allow the user to type anything.
2. Validation happens after submit / input checking.
3. Numeric value must be:
   - integer only
   - no letters
   - not empty
   - not negative
   - not greater than `999999999999`
4. Invalid input must show a clear validation error.
5. Do not silently convert invalid text into `0` or any default value.
6. Prefer preserving frontend and backend validation if already implemented.
7. Keep `maxlength="12"`, `inputmode="numeric"`, and `autocomplete="off"` unless there is a strong reason to adjust them.

Valid examples:

- `1`
- `100`
- `999999999999`

Invalid examples:

- `abc`
- `12abc`
- `-5`
- `1.5`
- empty input
- `1000000000000`

Max value: `999999999999`.

## Tailwind implementation notes

Refactor the Tailwind classes to feel less generated.

Avoid these current patterns:

- `bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900`
- excessive `backdrop-blur-xl`
- too many transparent white borders like `border-white/10`
- glowing shadows like `shadow-blue-500/30`
- oversized decorative icon block
- too much blue-on-blue layering

Prefer patterns like:

- `min-h-screen bg-slate-50 text-slate-900`
- `mx-auto max-w-2xl px-4 py-10 sm:py-16`
- `rounded-2xl border border-slate-200 bg-white shadow-sm`
- `text-slate-500`, `text-slate-700`, `text-slate-900`
- `focus:ring-2 focus:ring-blue-600`
- `bg-blue-600 hover:bg-blue-700`
- `rounded-lg` or `rounded-xl`, not always `rounded-3xl`

## Code safety checklist

Before finishing, verify:

- The form still submits to `route('calculate.submit')`.
- `@csrf` still exists.
- `id="tax-form"` still exists if the JavaScript uses it.
- `id="income"` still exists if the JavaScript uses it.
- `id="error-alert"` behavior still works.
- The JavaScript validation still targets the correct elements.
- `$taxAmount`, `$income`, and `$percentage` are still displayed correctly.
- The result only appears after calculation.
- The page is responsive.
- No backend or controller logic is changed unnecessarily.

## Expected result

After the update, the page should look like a clean, believable company tax calculator. It should no longer look like a generic AI-generated SaaS landing card. The logic should remain intact, because breaking working code just to make pixels prettier is how developers summon bugs from the basement.

---

# Short prompt for AI agent

Update `resources/views/calculate.blade.php` UI only using Tailwind. Keep all existing route/method/CSRF/input names/IDs/JS validation/result variables/calculation flow unchanged. Make the design less AI-generated: remove heavy dark gradient/glassmorphism/glow/oversized icon style, and redesign it as a clean professional PT. XYZ internal tax calculator with neutral background, white card, subtle border/shadow, readable typography, clear validation alert, and professional result summary. Do not change controller logic or tax calculation.
