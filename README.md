# Livewire Tiptap Editor

Easily integrate the Tiptap rich-text editor into your Laravel Livewire projects with full customization options.

This package is a result of my own tiptap integration.

I do want to shout out the awesome [Fluxui editor](https://fluxui.dev/components/editor) because the way they integrated the editor and provided options for usage has been of inspiration.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dudelisius/livewire-tiptap.svg?style=flat-square&include_prereleases)](https://packagist.org/packages/dudelisius/livewire-tiptap)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/dudelisius/livewire-tiptap/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/dudelisius/livewire-tiptap/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dudelisius/livewire-tiptap.svg?style=flat-square)](https://packagist.org/packages/dudelisius/livewire-tiptap)

## Installation

Install via Composer:
```bash
composer require dudelisius/livewire-tiptap:"0.1.0-alpha.1"
````

Publish config and assets:

```bash
php artisan vendor:publish --tag=livewire-tiptap-config
php artisan vendor:publish --tag=livewire-tiptap-assets
```

## Configuration

See `config/livewire-tiptap.php` for all options. The defaults provide sensible presets, but you can override:

* **`toolbar`**: define button tokens, groups (`|`), and spacers (`~`).
* **`use_default_classes`**: toggle Tailwind defaults on/off.
* **`classes`**: customize or target elements via fallback CSS class names.
* **`icons`**: map tokens to Blade component aliases (Tabler, Heroicons, custom SVG).
* **`extensions`**: configure Tiptap extensions like Link. [Link docs](https://tiptap.dev/docs/extensions/marks/link)

## Usage

Include styles and scripts in your layout:

```blade
@livewireTiptapStyles
@livewireStyles

<livewire-tiptap:editor wire:model="content" />

@livewireScripts
@livewireTiptapScripts
```

### Overriding the toolbar on demand

```blade
<livewire-tiptap:editor
    wire:model="content"
    toolbar="bold italic | link unlink | undo redo"
/>
```

### Disabling default classes

In your published config:

```php
'use_default_classes' => false,
```

All elements keep their fallback CSS class names, so you can style them in your own stylesheet.

## Advanced

### Extension Overrides

Pass extension settings directly:

```blade
<livewire-tiptap:editor
   wire:model="content"
   :extensions="[
       'link' => ['openOnClick' => false]
   ]"
/>
```

## Contributing & Testing

Please submit PRs and make sure it passes the Quality Assurance tests:

```bash
composer qa
```

## Roadmap

These items are not in chronological order

- [ ] Add more editor options
    - [ ] Strike
    - [ ] Subscript
    - [ ] Superscript
    - [ ] Text Style
    - [ ] Blockquote
    - [ ] Bullet list
    - [ ] Code block
    - [ ] Details
    - [ ] Details content
    - [ ] Details summary
    - [ ] Emoji
    - [ ] Hard break
    - [ ] Horizontal rule
    - [ ] Image
    - [ ] List item
    - [ ] Ordered list
    - [ ] Paragraph
    - [ ] Table
    - [ ] Table cell
    - [ ] Table header
    - [ ] Table row
    - [ ] Task list
    - [ ] Task item
    - [ ] Youtube
- [ ] Add image support
- [ ] Add image resize support
- [ ] Add image drag and drop upload support
- [ ] Add autosave
- [ ] Add screenshots to the readme
- [ ] Fix license
- [ ] Add a logo
- [ ] Write contributor guide
- [ ] Clean up repository
- [ ] Clean up repository users
- [ ] First stable release
- [ ] Add custom buttons
- [ ] Hook into tiptap events
- [ ] Add bubble menu support
