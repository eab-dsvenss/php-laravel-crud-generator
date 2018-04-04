# php-laravel-crud-generator
CRUD generator for existing models

# Installation 

`eab-crudgenerator:install`

# Usage 

Configure the models according to the `eab-dsvenss/php-laravel-model-generator`-package.

Each model in the modelgenerator-configfile that should have a crud-structure generated need to have the key `crud` appended to the extras array.

Each model that have translatable content should also be appended with `translatable` in the extras section.

Each translatable model also need to have the following added in a specific model-adjustments file:
```php
public $translatable = ['name'];
```
That is it needs to have an instance variable with an array specifying the translatable columns as a value.
See [Spatie laravel-translatable](https://github.com/spatie/laravel-translatable#making-a-model-translatable) for details regarding a model and how to make it translatable.

Specify which models to generate CRUD operations for in the config-file `eab-modelconfig` from the _eab-dsvenss:php-laravel-model-generator_ package
by adding a "crud"-key with value `true` to the modelarray.

## Generate CRUD structure
`eab-crudgenerator:generate --type="backpack"`

