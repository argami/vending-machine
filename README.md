# vending-machine [![Build Status](https://travis-ci.com/argami/vending-machine.svg?branch=main)](https://travis-ci.com/argami/vending-machine) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/745815bf30d44ed5abab2fb79628e03e)](https://www.codacy.com/gh/argami/vending-machine/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=argami/vending-machine&amp;utm_campaign=Badge_Grade)

VendingMachine Kata


Lets start with an simple version implementation and grow from it.


# Notes:

## Some assumptions made:

- Like in a real vending machine if the coin inserted isn't valid, and was able to put it inside, it will be returned immediately
- The returned money is return and forget we don't keep the track (like in a real one if you forget the change the next guy will enjoy it)
- When in a real VM i ask for an item without introducing money, will show the price of the item, there are some that if product is not available it will show it, but most of the one i used (old ones) it will wait to tell you the availability until you try to buy it. Here i will do what its mentioned at first.
- Normally the insert coin pocket (as for the amounts of denomination coin inside of the VM) has a fixed quantity of coins that can hold (there are other VM that work in some other way, talking about the insert pocket but its out of the scope). In my case i set up no limit for the amount of coins that can be inserted or stored.
- Some of the most newer VM allow to configure which Coins or Notes denominatiion are accepted.

## Things to take in consideration

- Normally in large code bases i work using the git-flow approach in small repos without more people than me avoid the overhead of using it, that is why in most of the development of this code i didn't use it


# TODO

Setup a VendingMachine class with the basic funcionality I/O (Simple version to construct from) 

- [x] Insert Coin
- [x] Coin Validation
- [x] Return money
- [ ] Sell Items 
- [ ] Need to improve coin name, using value is fragile 


- [ ] Cleaning test
