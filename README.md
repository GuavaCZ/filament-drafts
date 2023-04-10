![filament_drafts](https://user-images.githubusercontent.com/10926334/230881634-3fefdbe4-4301-48f3-8a8f-25b214a88c26.png)

# Filament Drafts

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guava/filament-drafts.svg?style=flat-square)](https://packagist.org/packages/guava/filament-drafts)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/guava/filament-drafts/php?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/guava/filament-drafts.svg?style=flat-square)](https://packagist.org/packages/guava/filament-drafts)

This plugin adds the ability to manage your model's drafts and revisions in your filament resources.

It's a filament implementation for [Laravel Drafts](https://github.com/oddvalue/laravel-drafts).



https://user-images.githubusercontent.com/10926334/230877140-ffaaf03a-5cad-4af5-8600-06dd5ab31e82.mov



## Installation

You can install the package with composer:

```bash
  composer require guava/filament-drafts
```

## Usage

### Model Trait
First make sure that you have correctly set-up a model to use drafts from Laravel Drafts.

At the very least you need to add a trait to your model:
```php
use Oddvalue\Drafts\HasDrafts;

class Post extends Model
{
    use HasDrafts;
}
```

and modify your migration:
```php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            //...
            $table->drafts();
        };
    }
}
```

After that, all you need to do is add a few traits to your resource and resource pages:

### Resource Trait
Add the `Draftable` trait to your Resource:

```php
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class PostResource extends Resource
{
    use Draftable;
}
```

### Resource Pages
Add the respective `Draftable` trait to your Resource Pages:
(Keep in mind that each page uses a different trait from another namespace)

#### Create Page
```php
use Guava\FilamentDrafts\Admin\Resources\Pages\Create\Draftable;

class CreatePost extends CreateRecord
{
    use Draftable;
}
```

#### Edit Page
```php
use Guava\FilamentDrafts\Admin\Resources\Pages\Edit\Draftable;

class EditPost extends EditRecord
{
    use Draftable;
}
```

#### List Page
```php
use Guava\FilamentDrafts\Admin\Resources\Pages\List\Draftable;

class ListPosts extends ListRecords
{
    use Draftable;
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Guava](https://github.com/GuavaCZ)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Other packages
- [Laravel Populator](https://github.com/GuavaCZ/laravel-populator)
- [Filament Icon Picker](https://github.com/LukasFreyCZ/filament-icon-picker)
