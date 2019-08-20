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
1. Copy Folder 'Commands' and paste to Laravel Folder in 'app\Console\Commands'
2. Copy FOlder 'stubs' and paste to Laravel Folder in 'resources'
```

## How to use
Run these commands in console.

Create a set of CRUD resources, for an example we want to create Procuct resources
```
php artisan crud:generate Product --route=true
```
*The option --route make the generator generate the resource route in web.php*

### Options
These are options with their default values

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

If you change the value to <b>false</b> the certain option will not be generated

6. Migrate
```
--view=false
```

Defaultly this is false, if you change the value to <b>true</b>, the generator will run <b>php artisan migrate:refresh</b> your tables
