# [cebe/markdown] Github Task Lists Support
[![Build Status](https://travis-ci.com/kirra/markdown-task-lists.svg?branch=master)](https://travis-ci.com/kirra/markdown-task-lists)
[![Coverage Status](https://coveralls.io/repos/github/kirra/markdown-task-lists/badge.svg?branch=master)](https://coveralls.io/github/kirra/markdown-task-lists?branch=master)

A trait to extend [cebe/markdown] with [Task Lists support].

## Installation
PHP 7.1 or higher is required to use it.

```bash
composer require kirra/markdown-task-lists
```

## Usage
To parse a Task List you need to make your own parser, and let it `use` the [TaskListsTrait].

```php
class MyParser extends \cebe\markdown\Markdown {
	use Kirra\Markdown\TaskListsTrait;
}

$parser = new MyParser();
$parser->parse("- [ ] Open"); // Will return a list with an open checkbox.
```

Everything after the checkbox will be parsed as inline elements. So you can still apply every inline style your parser
supports.   

## Usage in your own parser
If you build a fully custom parser, make sure it includes `cebe\markdown\block\ListTrait`, as the checkbox only works
within a list.

[cebe/markdown]: https://github.com/cebe/markdown
[Task Lists support]: https://github.blog/2013-01-09-task-lists-in-gfm-issues-pulls-comments
[TaskListsTrait]: './src/TaskListsTrait.php'
