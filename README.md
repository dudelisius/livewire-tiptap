# Livewire Tiptap Editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dudelisius/livewire-tiptap.svg?style=flat-square\&include_prereleases)](https://packagist.org/packages/dudelisius/livewire-tiptap)
[![Tests Passing](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/run-tests.yml?branch=main\&label=tests\&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/fix-php-code-style-issues.yml?branch=main\&label=code%20style\&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3A%22Fix+PHP+code+style+issues%22+branch%3Amain)
[![Downloads](https://img.shields.io/packagist/dt/dudelisius/livewire-tiptap.svg?style=flat-square)](https://packagist.org/packages/dudelisius/livewire-tiptap)

Easily integrate the Tiptap rich-text editor into your Laravel Livewire projects, with full customization, dropdowns, and translation support.

---

## 📋 Prerequisites

Livewire Tiptap requires the following before installing:

* **PHP** ≥ 8.3
* **Laravel** ≥ 11.x
* **Livewire** ≥ 3.6

---

## 🚀 Installation

```bash
composer require dudelisius/livewire-tiptap:"0.1.0-alpha.3"
```

Optional; publish the assets, views, and config:

```bash
php artisan vendor:publish --tag=livewire-tiptap-config
php artisan vendor:publish --tag=livewire-tiptap-views
php artisan vendor:publish --tag=livewire-tiptap-assets
```

---

## ⚙️ Configuration

All settings live in `config/livewire-tiptap.php`. The defaults are opinionated but sensible. You can override:

* **`toolbar`**: list of tokens, separators (`|`), spacers (`~`), or dropdown groups (`[...]`).
* **`use_default_classes`**: turn the built-in Tailwind classes on/off.
* **`classes`**: define your own class names or target elements via fallback keys.
* **`icons`**: map tokens to Blade component aliases (Tabler, Heroicons, or your own SVG).
* **`buttons`**: configure per-button icon, label, etc.
* **`extensions`**: pass through Tiptap extension options (e.g. Link). See for example the [Tiptap Link docs](https://tiptap.dev/docs/extensions/marks/link).

---

## 🎨 Usage

This package is a Livewire component:

```blade
<livewire:tiptap wire:model="content" />
```

### Load the assets

You need the package CSS + JS on pages that render the editor.

#### Option A (recommended): publish assets and include via `<link>` + directive

Publish the assets:

```bash
php artisan vendor:publish --tag=livewire-tiptap-assets
```

Then include them in your layout:

```blade
@livewireStyles

<link rel="stylesheet" href="{{ asset('vendor/livewire-tiptap/css/livewire-tiptap.css') }}">

<livewire:tiptap wire:model="content" />

@livewireScripts
@livewireTiptapScripts
```

#### Option B: import from `vendor/` via Vite

In `resources/css/app.css`:

```css
@import "../../vendor/dudelisius/livewire-tiptap/resources/dist/css/livewire-tiptap.css";
```

In `resources/js/app.js`:

```js
import '../../vendor/dudelisius/livewire-tiptap/resources/dist/js/livewire-tiptap.js'
```

Make sure Alpine is loaded globally (the JS hooks into `alpine:init`).

---

## 🧑‍💻 Package Development (local watcher)

If you're developing this package alongside a local Laravel app (for example a sibling folder `../pegasus`), you can run a watcher that automatically:

1. Builds the package assets into `resources/dist`
2. Publishes them into the Laravel app via `vendor:publish --tag=livewire-tiptap-assets --force`
3. Clears caches via `optimize:clear`

From the package root:

```bash
bun run dev
```

One-off sync (no watcher):

```bash
bun run sync:pegasus
```

---

## 🛠 The Toolbar

The toolbar lets users style content. You can configure it in several ways:

### Simple Buttons

Just add the token for each extension:

```php
'toolbar' => 'bold italic underline strike'
```

### Separator

Group buttons with a vertical bar:

```php
'toolbar' => 'bold italic | underline strike'
```

### Spacer

Push later buttons to the right:

```php
'toolbar' => 'bold italic ~ undo redo'
```

### Dropdown Groups

Group options in a dropdown by wrapping tokens in `[...]`.
The dropdown shows the first icon by default, and updates to reflect the active formatting.

```php
'toolbar' => '[paragraph heading-1 heading-2 heading-3] | bold italic'
```

### Per-Component Override

Override the toolbar when rendering:

```blade
<livewire:tiptap
    wire:model="content"
    toolbar="bold italic | link unlink | undo redo"
/>
```

---

## 🎨 Styling

All default classes use Tailwind and live in the config under `classes`.
If you prefer your own CSS, either customize each key or disable defaults:

```php
'use_default_classes' => false,
```

---

## 🔧 Advanced

### Extension Overrides

Pass extension options at render time:

```blade
<livewire:tiptap
   wire:model="content"
   :extensions="[
       'link' => ['autolink' => false],
   ]"
/>
```

Or edit them in your published config:

```php
'extensions' => [
    'link' => [
        'autolink' => false,
        // …
    ],
],
```

### Supported Extensions

* paragraph
* heading-1
* heading-2
* heading-3
* heading-4
* heading-5
* heading-6
* bold
* italic
* underline
* strike
* blockquotes
* code
* highlight
* hardBreak
* horizontalRule
* bulletList
* orderedList
* subscript
* superscript
* emojis
* [link](https://tiptap.dev/docs/extensions/marks/link)
* unlink
* undo
* red

More coming soon!

---

## 🌐 Translations

This package ships with English, Dutch, French, and Spanish translations.
To add your own, submit a PR or drop a file into:

```
resources/lang/livewire-tiptap/{locale}.php
```

---

## 🤝 Contributing & Testing

PRs are very welcome! Please run the full QA suite before submitting:

```bash
composer qa
```

---

## 📈 Roadmap

* [~] Additional Tiptap extensions (blockquote, image, tables, etc.)
* [ ] Image uploads & drag-drop support
* [ ] Autosave & Ctrl+S handling
* [ ] Bubble menus
* [ ] Sticky toolbar (optional)
* [~] Add align button
* [ ] Add YouTube button
* [ ] Add embed button
* [ ] Add details/summary button
* [ ] Improve readme on how to set the language
* [ ] Auto show scroll arrows on narrow screens
* [ ] Make the view files publishable
* [ ] Improved documentation & examples
* [~] Add the option to add buttons by passing the into the editor
* [~] Make accessible
* [ ] First stable (1.0) release
* [~] Improve package setup and codebase
* [x] Button tooltips
* [x] Add an option for setting placeholders
* [x] Add an option for enabling or disabling the focus within
* [x] Add option to override the editor class from calling the editor
* [x] Add chevron to dropdowns
* [x] Add label option
* [x] Add options for custom labels from config
* [x] Fix css compiling and make sure it does not conflict with existing tailwind in projects
* [x] Remove style blade directie and import via css file
* [x] Add error styling to the wrapper
* [x] Add label item to component
* [x] Flux styling as base
