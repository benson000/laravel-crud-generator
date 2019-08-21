# Laravel CRUD Generator

This script is created for generating Laravel's normal CRUD.
We don't need no more creating CRUD with the same way again. 
Say bye to boring routines.

## Getting Started
For installing this CRUD Generator on laravel, please do the following things.

### Prerequisites
```
Laravel >= 5.6
```

### Installing
Follow these steps to install the generator.
```
1. Download the repositories to your computer
2. Copy Folder 'Commands' and paste to Laravel Folder in 'app\Console\Commands'
3. Copy Folder 'stubs' and paste to Laravel Folder in 'resources'
```

## How to use
Run these commands in console.

Create a set of CRUD resources, for an example we want to create Procuct resources
```
php artisan crud:generate Product --route=true
```
*The option --route make the generator generate the resource route in web.php*

### Options
These are options with their default values, in default it has value of <b>true</b>, while the condition still true, the element such as <b>Controller</b>, <b>Model</b>, <b>Migration</b>, <b>Route</b>, <b>View</b> will be generated. Add the option to disable generating of certain element(s).

1. Controller
```
--controller=true
```

2. Model
```
--model=true
```

3. Migration
```
--migration=true
```

4. Route
```
--route=true
```

5. View
```
--view=true
```

By default, migrate value is <b>false</b>, if you change the value to <b>true</b>, the generator will run <b>php artisan migrate:refresh</b> to your database

6. Migrate
```
--view=false
```

#### Example
Case: I want to create a CRUD Resource for <b>Products</b>, but i do not want the <b>route</b> and <b>migration</b> to be generated, then the command will be like this

```
php artisan crud:generate Product --route=false --migration=false
```

*Note: Please use singular expression for a resource*
