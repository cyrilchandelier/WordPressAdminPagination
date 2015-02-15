# WordPressAdminPagination
Easy to integrate WordPress admin style pagination for themes and plugins
![ScreenShot](https://raw.github.com/cyrilchandelier/WordPressAdminPagination/master/screenshot.png)

## Installation
Copy the ```WordPressAdminPagination.php``` file into your theme or plugin (for instance in a  ```Externals/WordPressAdminPagination/``` folder).

Include or require the script in order to use it:
```php
require_once 'WordPressAdminPagination.php';
```

This class uses PHP namespaces so you should ```use CC;``` or prefix your object creation with ```\CC``` if necessary.

## How to use
Create a pagination object and configure it by setting the ```totalItems``` property:
```php
$pagination = new \CC\WordPressAdminPagination();
$pagination->totalItems = $currentCount;
```

To display the pagination component in your template, just call the ```show()``` method on your pagination object:
```php
<?php $pagination->show(); ?>
```

In order to use the common WordPress admin style, this call should be done in a ```tablenav``` (```top``` or ```bottom```) ```div```:
```html
<div class="tablenav top">
    <?php $pagination->show(); ?>
    <br class="clear">
</div>
```

## Options
The max number of displayed items can be changed by setting a new limit to the pagination object (default is 25):
```php
$pagination->limit = 50;
```

The URL parameters used for pagination can be changed by settings a new string to the pagination object (default is "paged"):
```php
$pagination->parameter = "p";
```