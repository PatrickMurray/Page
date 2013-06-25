# Page

Page is a simple PHP script that facilitates fast implementation of templates in a simple manner.

___

## Methods

#### open()
##### Arguments:
 1. ```$filepath```	- String expected.  Defines the path of the file to be read.  Default value: ```layout.html```.
 2. ```$append```	- Boolean expected.  Determines whether or not the file's contents will be assigned as class'
 ```content``` property or appended to the current ```contents``` property.  Default value: ```True```.

The open method, as its name suggests, opens and reads files.  ```$filepath``` must point to an existing file
that PHP has read access.

If ```$append``` is ```True```, the contents
of the file will be appended to the end of the class' ```contents``` property; however, a ```False``` value will
result in the ```contents``` property being overridden by the file's contents.

#### close()
##### Arguments: **None**

The close method assigns the class' property ```contents``` the value of an empty string.

#### replace()
##### Arguments:
 1. ```$name```		- String expected.  Defines the inner content of a comment.  Default value: ```""```
 2. ```$val```		- String, float, or integer expected.  Default value: ```""```
 3. ```$format```	- Array expected.  Default value: ```[["<!-- "," -->"], ["<!--","-->"], ["/* "," */"],
 ["/*","*/"]]```

The replace method replaces comments, provided with the first argument, in the class' ```contents``` property
with the provided value, the second argument.  The comment types to replace are stored in the third argument as
an array.

#### output()
##### Arguments: **None**

The output method returns the value of the class' ```contents``` property.  By default, the output method is
called upon the instance's destruction.  However, this may be changed when creating the instance by providing an
array with the key ```output``` and a boolean value.  A ```True``` value will print the ```contents``` property
upon calling ```__destruct()```, while a ```False``` value will not.


## Implementation

For the following examples, lets assume that ```'path/to/template.html'``` has the following syntax:

```html
<!DOCTYPE html>
<html>
	<head>
		<title><!-- title --></title>
	</head>
	<body>
		<!-- contents -->
	</body>
<html>
```

##### Simple Example
```php
<?php

require_once('../page.php');

# Create instance and open template
$page = new page;
$page->open('path/to/template.html');

?>
```

Outputs the content's of ```path/to/template.html```.

##### Replacing Comments

```php
<?php

require_once('../page.php')

$page = new page();
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Some content should go here...");

?>
```

Ouput:
```html
<!DOCTYPE html>
<html>
	<head>
		<title>Page Documentation!</title>
	</head>
	<body>
		Some content should go here...
	</body>
<html>
```

##### Compression Example

```php
<?php

require_once('../page.php')

$page = new page(['compress'=>True]);
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Some content should go here...");

?>
```

Ouput:
```html
<!DOCTYPE html><html><head><title>Page Documentation!</title></head><body>Some content should go here...</body><html>
```

##### Ignoring Compression

```php
<?php

require_once('../page.php')

$page = new page(['compress'=>True]);
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Please Comment:<br><textarea></textarea>");

?>
```

Outputs the content's of ```path/to/template.html```.

##### Replacing Comments

```php
<?php

require_once('../page.php')

$page = new page();
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Some content should go here...");

?>
```

Ouput:
```html
<!DOCTYPE html>
<html>
	<head>
		<title>Page Documentation!</title>
	</head>
	<body>
		Some content should go here...
	</body>
<html>
```

##### Compression Example

```php
<?php

require_once('../page.php')

$page = new page(['compress'=>True]);
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Some content should go here...");

?>
```

Ouput:
```html
<!DOCTYPE html><html><head><title>Page Documentation!</title></head><body>Some content should go here...</body><html>
```

##### Ignoring Compression

```php
<?php

require_once('../page.php')

$page = new page(['compress'=>True]);
$page->open('path/to/template.html');

# Replacing comments
$page->replace('title', "Page Documentation!");
$page->replace('content',"Please Comment:<br><textarea></textarea>");

?>
```

Ouput:
```html
<!DOCTYPE html>
<html>
	<head>
		<title>Page Documentation!</title>
	</head>
	<body>
		Please Comment:<br><textarea></textarea>
	</body>
<html>
```