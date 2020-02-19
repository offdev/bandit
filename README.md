# Offdev/Bandit
An A/B/x testing algorithm written in PHP by implementing the solution to the multi armed bandit problem

[![Latest Stable Version](https://img.shields.io/packagist/vpre/offdev/bandit.svg?style=flat-square)](https://packagist.org/packages/offdev/bandit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/offdev/bandit/master.svg?style=flat-square)](https://travis-ci.org/offdev/bandit)
[![License](https://img.shields.io/github/license/offdev/bandit.svg)](https://www.apache.org/licenses/LICENSE-2.0)

## Requirements
* PHP >= 7.4
* Composer

## Installation
```bash
$ composer require offdev/bandit
```

## General Usage
First, you need to setup a machine, and its possible levers. A lever might have already been pulled a few times, and some levers may also have rewarded the lucky dude which pulled it, so adjust those numbers accordingly. Example:
```php
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;

$machine = new Machine(
    new Lever('first-lever', 123, 1),
    new Lever('second-lever', 108, 3),
    new Lever('third-lever', 115, 0),
);
```

Now you need a strategy to solve your problem. See [this link](https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies) for more information about strategies, and have a look at the example ones I have included in `src/php/Strategies`. Example:
```php
use Offdev\Bandit\Strategies\EpsilonGreedy;

$strategy = new EpsilonGreedy();
$winningLever = $strategy->solve($machine);
```

It is as simple as that :)

## TODO
Add more docs :)