![GitHub](https://img.shields.io/github/license/manogi/nova-tiptap)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/manogi/nova-tiptap)

# Laravel Nova Tiptap Editor Field

A Laravel Nova implementation of the [tiptap editor for Vue.js](https://github.com/ueberdosis/tiptap) by [@ueberdosis](https://github.com/ueberdosis).

## Installation

Install via composer:

``` php
composer require manogi/nova-tiptap
```

## Usage with default settings:

``` php
Tiptap::make('FieldName')
```

This will give you just the bold and italic buttons.

You will also have to add this `use` statement to the top of the file:

``` php
use Manogi\Tiptap\Tiptap;
```


## Usage with your selection of buttons:

``` php
Tiptap::make('FieldName')
  ->buttons([
        'heading',
        '|',
        'italic',
        'bold',
        '|',
        'code',
        'link',
        'strike',
        'underline',
        'highlight',
        '|',
        'bulletList',
        'orderedList',
        'br',
        'codeBlock',
        'blockquote',
        '|',
        'horizontalRule',
        '|',
        'table',
        '|',
        'textAlign',
        '|',
        'image',
        '|',
        'history',
        '|',
        'editHtml',
    ])
    ->headingLevels([2, 3, 4]),
```

When just passing the string `'heading'` you will have H1, H2 and H3 to choose from. You can set the level of headings by using for example `headingLevels([2, 3, 4])` which will give you H2 through H4.

### The two different "code" buttons

`'code'` is inline code (like `<code></code>`) while `'code_block'` will give you `<pre><code></code></pre>`.

## Syntax Highlighting when using `codeBlock`

``` php
Tiptap::make('FieldName')
  ->buttons([
      'italic',
      'bold',
      'code',
      'codeBlock'
  ])
  ->syntaxHighlighting(),
```

When using `'codeBlock'` you can turn on syntax highlighting by using `syntaxHighlighting()`.

## Edit HTML

the `'editHtml'` option will enable the ability to toggle to the tiptap editor to a textarea and manually edit the HTML

### HTML theme when using `editHtml`

``` php
Tiptap::make('FieldName')
  ->buttons([
      'italic',
      'bold',
      'code',
      'editHtml'
  ])
  ->htmlTheme('night'),
```

When using `'editHtml'` you can set the theme by using using `htmlTheme()`. The default theme used is "material". You can find all the codemirror themes used [here](https://codemirror.net/demo/theme.html) .

## Visibility in index view

Like `Textarea` and `Trix` fields this field is hidden from index views. You can make the content visible by using a [computed field](https://nova.laravel.com/docs/3.0/resources/fields.html#computed-fields).

## Screenshots

The tiptap editor with all the buttons:

![the tiptap editor with all the buttons](readme-images/all-buttons.png)

The idea is that the editor can be themed together with the rest of Nova - here it is looking differently just by using the [Laravel Nova Stripe Theme](https://github.com/jameslkingsley/nova-stripe-theme):

![the tiptap editor with all the buttons](readme-images/stripe-theme.png)

## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
