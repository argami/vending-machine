# vending-machine [![Build Status](https://travis-ci.com/argami/vending-machine.svg?branch=main)](https://travis-ci.com/argami/vending-machine) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/745815bf30d44ed5abab2fb79628e03e)](https://www.codacy.com/gh/argami/vending-machine/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=argami/vending-machine&amp;utm_campaign=Badge_Grade)

VendingMachine Kata


Lets start with an simple version implementation and grow from it.

# How To run it

```bash
php src/prompt.php
```

# Requirements

## Packages

- ext-xdebug
- ext-ds


# Notes:

I think the code and git log will give a lot of insight of why/how i did X in this project. But to be sure i add some comments that might be of help:

## Some assumptions made:

- Like in a real vending machine if the coin inserted isn't valid, and was able to put it inside, it will be returned immediately
- The returned money is return and forget we don't keep the track (like in a real one if you forget the change the next guy will enjoy it)
- When in a real VM i ask for an item without introducing money, will show the price of the item, there are some that if product is not available it will show it, but most of the one i used (old ones) it will wait to tell you the availability until you try to buy it. Here i will do what its mentioned at first.
- Normally the insert coin pocket (as for the amounts of denomination coin inside of the VM) has a fixed quantity of coins that can hold (there are other VM that work in some other way, talking about the insert pocket but its out of the scope). In my case i set up no limit for the amount of coins that can be inserted or stored.
- Some of the most newer VM allow to configure which Coins or Notes denominatiion are accepted.
- Most of the VM goes to Service mode when the door is open, in this case i will prepare a command to go SERVICE and one to STOP SERVICE

## Things to take in consideration

- I try at my best to not use packages, with the exception of Ds\* (Hashable, Set) that allows me to have a base collection/unique item implementation
- Normally in large code bases i work using the git-flow approach but for small repos/projects, working alone and in the begin of the project i dont use it to remove the overhead of it, that is why in most of this project i didn't use it.
- I have use PHPUnit for some time, but i dont really like the way the testing API is done, that is why i use atoum, which i found more expresive, and easy to understand at first look


# Extras

## TODO

Setup a VendingMachine class with the basic funcionality I/O (Simple version to construct from) 

- [x] Insert Coin
- [x] Coin Validation
- [x] Return money
- [x] Sell Items 
- [ ] Need to improve coin name, using value (in float format) is fragile
- [x] Coins aren't infinite 
- [ ] "CRUD" for items (coins, products)
- [x] Refactoring Coin/CoinSet from CoinManager
- [ ] To avoid floating issues move all calculations to cents and denominations to string
- [ ] Create exceptions classes and set a logic number system
- [ ] Should Change Coin to somethning like Currency (maybe is not the best name for it?) to be more flexible in case of adding bank notes
- [ ] update readme and try Ds\* pollyfills in case of not be posible to install the extension (https://github.com/php-ds)
- [ ] Move code to a lib folder
- [ ] Because of the internal ordering the tests are right now fragile i need to change that on the tests

### service status

- [ ] set service status
- [ ] status can't sell products
- [ ] should be able to change coins amounts/denominations (add, remove, update)
- [ ] should be able to change products (add, remove, update) 
- [ ] get log of work? and reset log

- [ ] Cleaning tests


### Interfaces

#### Terminal UI

#### Terminal UI2

#### Terminal Rest/HTML

### Extras

- [ ] be able to set a tests in file with multiline action to tests commands (terminal interfaces mainly/ and underlying lib)

## Doubts

- Instead of the normal throwing error approach should i use a near json rest, way of returning error with the error key and the results?