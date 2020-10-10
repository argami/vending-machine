# vending-machine [![Build Status](https://travis-ci.com/argami/vending-machine.svg?branch=main)](https://travis-ci.com/argami/vending-machine) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/745815bf30d44ed5abab2fb79628e03e)](https://www.codacy.com/gh/argami/vending-machine/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=argami/vending-machine&amp;utm_campaign=Badge_Grade)

VendingMachine Kata


Lets start with an simple version implementation and grow from it.


# Notes:

I think the code and git log will give a lot of insight of why/how i did X in this project. But to be sure i add some comments that might be of help:

## Some assumptions made:

- Like in a real vending machine if the coin inserted isn't valid, and was able to put it inside, it will be returned immediately
- The returned money is return and forget we don't keep the track (like in a real one if you forget the change the next guy will enjoy it)
- When in a real VM i ask for an item without introducing money, will show the price of the item, there are some that if product is not available it will show it, but most of the one i used (old ones) it will wait to tell you the availability until you try to buy it. Here i will do what its mentioned at first.
- Normally the insert coin pocket (as for the amounts of denomination coin inside of the VM) has a fixed quantity of coins that can hold (there are other VM that work in some other way, talking about the insert pocket but its out of the scope). In my case i set up no limit for the amount of coins that can be inserted or stored.
- Some of the most newer VM allow to configure which Coins or Notes denominatiion are accepted.

## Things to take in consideration

- Normally in large code bases i work using the git-flow approach but for small repos/projects, working alone and in the begin of the project i dont use it to remove the overhead of it, that is why in most of this project i didn't use it.
- I have use PHPUnit for some time, but i dont really like the way the testing API is done, that is why i use atoum, which i found more expresive, and easy to understand at first look


# TODO

Setup a VendingMachine class with the basic funcionality I/O (Simple version to construct from) 

- [x] Insert Coin
- [x] Coin Validation
- [x] Return money
- [ ] Sell Items 
- [ ] Need to improve coin name, using value (in float format) is fragile
- [ ] Coins aren't infinite 
- [ ] "CRUD" for items (coins, products)


- [ ] Cleaning test
