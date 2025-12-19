My solution for the following kata [2 kyu](https://www.codewars.com/kata/52a78825cdfc2cfc87000005)

This handles the test values:
['1+1', 2.0],
['1 - 1', 0.0],
['1* 1', 1.0],
['1 /1', 1.0],
['-123', -123.0],
['123', 123.0],
['2 /2+3 * 4.75- -6', 21.25],
['12* 123', 1476.0],
['2 / (2 + 3) * 4.33 - -6', 7.732],

But does not handle complex, attempt values:  
- 12* 123/-(-5 + 2) _`/-(-` can't be handled_  
- 3 + -4 * -6 - 13 - -1 * -11232 / (2 + 3) * 4.33 - -65 + -6 / -212 * -123(1 - 2) + -(-(-(-4))) _`-(-(-(-4)))` can't be handled_