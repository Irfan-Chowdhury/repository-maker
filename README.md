<div align='center'>

# Laravel Repository Maker
</div>

## About Repository Design Pattern: 
The Repository Design Pattern is a software design principle commonly used in the development of applications that interact with data storage systems, such as databases. It provides an abstraction layer between the application's data access logic and the underlying data storage, promoting separation of concerns and modularity in the codebase.

In short, the Repository Design Pattern involves creating classes or interfaces called repositories, which encapsulate the methods and operations for interacting with the data storage. These repositories abstract away the details of how data is retrieved, stored, and manipulated, making the application's codebase more maintainable and testable. This pattern also helps in centralizing data access logic, improving code reusability, and facilitating the management of complex queries.

## Requirement: 

```bash
    "require": {
        "php": ">=7.4",
        "laravel/framework": ">=8.0"
    }
```

## Installation

You can install the package via composer:

```bash
composer require irfan-chowdhury/repository-maker
```

## Setup

After installation goto `config/app.php` and paste the bellow line in "providers" array

```bash
'providers' => [
    /*
    * Package Service Providers...
    */
    Irfan\RepositoryMaker\RepositoryServiceProvider::class,
]
```

## Usage

If you now run `php artisan` you will see some new commands in the list:
- `make:contract`
- `make:contract-base`
- `make:contract-extends`
- `make:repository`
- `make:repository-i`
- `make:repository-base`
- `make:repository-extends`
- `make:service`
- `make:repository-i-s`

### Commands
```bash
$ php artisan make:contract NameContract
$ php artisan make:contract-base
$ php artisan make:contract-extends NameContract
$ php artisan make:repository NameRepository
$ php artisan make:repository-i NameRepository
$ php artisan make:repository-base
$ php artisan make:repository-extends NameRepository
$ php artisan make:service NameService
$ php artisan make:repository-i-s NameRepository
```

### Note: 
- <i> Before using repository you have to ensure that your model class exists or not. </i>
- <i> You have to register the dependency in `register()` method in `AppServiceProvider`. If you want you can create a custom service provider. Following the bellow code - </i>

```bash
use App\Contracts\NameContract;
use App\Repositories\NameRepository;

...

public function register(): void
{
    $this->app->bind(NameContract::class, NameRepository::class);
}

```


## Example

Let you have a User Model according to this namespace `App\Models\User.php`

### Creating Interface 
it will generate an interface according to this path `app/Contracts/UserContract.php`. Here we named this interface as Contract.

```bash
$ php artisan make:contract UserContract
```

### Creating a Base Interface 
It is optional but if you want to use a base, it will generate an interface according to this path `app/Contracts/BaseContract.php`. Here we named this interface as Contract.

```bash
$ php artisan make:contract-base
```


### Creating an Interface with extends Base Interface
If you want to extends with the Base Interface, it will generate an interface according to this path `app/Contracts/UserContract.php` and extends with `BaseContract`.

```bash
$ php artisan make:contract-extends UserContract
```

Note: But before using extends with the Base interface, you have to create a BaseContract before (using only `make:contract-base`).

### Creating Repository 
It will generate a repository class according to this path `app/Repositories/UserRepository.php`.
```bash
$ php artisan make:repository UserRepository
```

### Creating Repository with interface
It will generate a repository class with interface according to this path `app/Repositories/UserRepository.php` and `app/Contracts/UserContract.php`. 
```bash
$ php artisan make:repository-i UserRepository
```

### Creating a Base Repository 
It is optional but if you want to use a base, it will generate a repository class according to this path `app/Repositories/BaseRepository.php`.

```bash
$ php artisan make:repository-base
```

### Creating a Repository with extends the Base Repository
If you want to extends with Base Repository, it will generate a Repository class according to this path `app/Repositories/UserRepository.php` and extends with `BaseRepository`.

```bash
$ php artisan make:repository-extends UserRepository
```

Note: But before using extends with the Base repository, you have to create a BaseRepository class before (using only `make:repository-base`).


### Creating Service Class 
It is optional but sometimes we need to use a service class to maintain business logic. If you want to use a service class, it will generate a service class according to this path `app/Services/UserService.php`.

```bash
$ php artisan make:service UserService
```

### Creating Repository with interface and service
It will generate a repository class with interface and service according to this path `app/Repositories/UserRepository.php`, `app/Contracts/UserContract.php`, `app/Services/UserService.php`. 
```bash
$ php artisan make:repository-i-s UserRepository
```

<br>
After then you have to register in a service provider -

```bash
use App\Contracts\UserContract;
use App\Repositories\UserRepository;

...

public function register(): void
{
    $this->app->bind(UserContract::class, UserRepository::class);
}
```

### Inject in Controller/Service class
In your controlleror, you can use them,

```bash
use App\Contracts\UserContract;
...

public function __construct(public UserContract $userContract){}

public function index()
{
    return $userContract->latest()->first();
}
```

## Visit
Packagist : https://packagist.org/packages/irfan-chowdhury/repository-maker

## Credits
- Inspired by [Abdullah Al Zuhair](https://github.com/zuhair2025)
- Resources - [Bitfumes](https://www.youtube.com/@Bitfumes) and [Maniruzzaman Akash](https://www.youtube.com/@Maniruzzaman)
- Structure follow from - [spatie/package-skeleton-laravel](https://github.com/spatie/package-skeleton-laravel)
 