# Offdev/Bandit
An A/B/x testing algorithm written in PHP by implementing the solution to the multi armed bandit problem

[![Latest Stable Version](https://img.shields.io/packagist/v/offdev/bandit.svg?style=flat-square)](https://packagist.org/packages/offdev/bandit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/offdev/bandit/master.svg?style=flat-square)](https://travis-ci.org/offdev/bandit)

### Requirements
* PHP >= 7
* Composer

### Installation
```bash
$ composer require offdev/bandit
```

### Usage
First, you need to setup a machine, and its possible levers. A lever might have already been pulled a few times, and some lever may also have rewarded the lucky dude which pulled it, so adjust those numbers accordingly. Example:
```php
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;

$machine = new Machine();
$lever1 = new Lever('first-lever');
$lever2 = new Lever('second-lever');
$lever3 = new Lever('third-lever');

$lever1->setTries(123)->setRewards(1);
$lever2->setTries(108)->setRewards(3);
$lever3->setTries(115)->setRewards(0);

$machine->addLever($lever1)->addLever($lever2)->addLever($lever3);
```

Now you need a strategy to solve your problem. See [this link](https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies) for more information about strategies, and have a look at the example ones I have included in `src/php/Strategies`. Example:
```php
use Offdev\Bandit\Machine;
use Offdev\Bandit\Tester;
use Offdev\Bandit\Strategies\EpsilonGreedy;

$strategy = new EpsilonGreedy(0.1);
$tester = new Tester();
$tester->setMachine($machine);
$tester->setStrategy($strategy)

$winningLever = $tester->run();
```

### Donations
Any donation will help me get some more pot, so you can enjoy more of my coding ^_^
* Bitcoin: **1DJEjfs3eFcvtPR6DWrZmtZ28jBbEdNB9C**