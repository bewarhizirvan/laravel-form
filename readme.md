# LaravelForm

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require bewarhizirvan/laravel-form
```

## Usage

For initiating new form
``` php
$form = new \BewarHizirvan\LaravelForm\LaravelForm($parameters);
```
$parameters must be an array and is optional, all keys are optional
>title  : Form Title  
>name	: Form name  
>method	: Form method { get, post, put, patch }
>class	: Form class  
>role	: Form role  
>dir    : Form direction { right, left (default) }  
>id     : Form id  
>file	: if you set a value to it , the Form will have enctype="multipart/form-data"  
>submit	: Form submit button title, if you set it to 'none' it will be removed  
>back_url	: Form Back button URL, if you set it to 'none' it will be removed
>
For form action One of these you can use  
>url	: Full URL  
>route	: Route { only route string or array Laravel Style }  
>action	: Action { only action string or array Laravel Style }
>

###Functions
```php
$form->addText($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])  
$form->addFile($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])  
$form->addButton($label = '', $input_par = [])  
$form->addHidden($input_name = null, $input_value = '', $input_par = [])  
$form->addSelect($select_name= null, $select_options = [], $select_value='',$select_par = [],$label=null, $label_par = [], $div_par = [])  
$form->addTextArea($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])  
$form->addCheckbox($input_name = null, $input_value = 1, $checked = false, $input_par = [], $label = null, $label_par = [], $div_par = [])  
$form->addCheckboxGroup($input_name = null, $checkboxes = [], $checked_list = [], $input_par = [], $label = null, $label_par = [], $div_par = [])  
$form->addTable($label = '', $table_data = [], $label_par = [], $table_par = [], $thead_par = [], $tbody_par = [], $tfoot_par = [], $div_par = [])
```
### When finished do bellow
```php
$form = $form->render();
```
>the above step will generate an html code


###Example form
```php
$form = new \BewarHizirvan\LaravelForm\LaravelForm($parameters);
$form->addText('email');
$form->addText('name');
$form->addText('password', '', ['type' => 'password']);
$form = $form ->render();
```



## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email bewar@hizirvan.email instead of using the issue tracker.

## Credits

- [Bewar Hizirvan][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/bewarhizirvan/laravel-form.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bewarhizirvan/laravel-form.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bewarhizirvan/laravel-form/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/bewarhizirvan/laravel-form
[link-downloads]: https://packagist.org/packages/bewarhizirvan/laravel-form
[link-travis]: https://travis-ci.org/bewarhizirvan/laravel-form
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/bewarhizirvan
[link-contributors]: ../../contributors
