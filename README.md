# Livewire Tiptap Editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dudelisius/livewire-tiptap.svg?style=flat-square\&include_prereleases)](https://packagist.org/packages/dudelisius/livewire-tiptap)
[![Tests Passing](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/run-tests.yml?branch=main\&label=tests\&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/fix-php-code-style-issues.yml?branch=main\&label=code%20style\&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3A%22Fix+PHP+code+style+issues%22+branch%3Amain)
[![Downloads](https://img.shields.io/packagist/dt/dudelisius/livewire-tiptap.svg?style=flat-square)](https://packagist.org/packages/dudelisius/livewire-tiptap)

Easily integrate the Tiptap rich-text editor into your Laravel Livewire projects, with full customization, dropdowns, and translation support.

---

## 📋 Requirements

* **PHP** ≥ 8.3
* **Laravel** ≥ 11.x
* **Livewire** ≥ 3.6

---

## 🚀 Installation

```bash
composer require dudelisius/livewire-tiptap:"0.1.0-alpha.2"
```

Then publish the assets, views, and config:

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
* **`extensions`**: pass through Tiptap extension options (e.g. Link). See the [Link docs](https://tiptap.dev/docs/extensions/marks/link).

---

## 🎨 Usage

Include the styles & scripts in your layout:

```blade
@livewireTiptapStyles
@livewireStyles

<livewire-tiptap:editor wire:model="content" />

@livewireScripts
@livewireTiptapScripts
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
<livewire-tiptap:editor
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
<livewire-tiptap:editor
   wire:model="content"
   :extensions="[
       'link' => ['openOnClick' => false],
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
* heading-1 … heading-6
* bold, italic, underline, strike
* code, highlight
* bulletList, orderedList
* subscript, superscript
* link, unlink
* undo, redo

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

* [ ] Additional Tiptap extensions (blockquote, image, tables, etc.)
* [ ] Image uploads & drag-drop support
* [ ] Autosave & Ctrl+S handling
* [ ] Bubble menus & tooltips
* [ ] Improved documentation & examples
* [ ] First stable (1.0) release
