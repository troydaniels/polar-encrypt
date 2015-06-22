# polar-encryption

By taking [Fermat's spiral](http://mathworld.wolfram.com/FermatsSpiral.html), and a random key, we can set up a seemingly strong encryption.

First, we pick a base **b**, and map integers [0..b-1] to random, unique, integers in the range  [1..inf).
We also genterate an array of length l, b < l <= b^2, containing randomly generated, unique integers k, st. 1 < k < l.
These mappings **M**, **N**, together with the base, for the encryption and decryption key, which should, using some other method, be distributed to communication endpoints.

To encrypt a message, the message must in some way be converted to a base b representation. For example, for a typical
character string, converting the ASCII code of the characters to base b.

Then, we map each element **e_sub_i** of this value in the base b using **M(e_sub_i)=n_sub_i**.

We find the positive n_sub_i-th root of Fermat's Spiral (r=theta), and then find the value **N(i mod |N|)**.

Finally, we find the N(i mod |N|)-th intersection of the perpendicular to the n_sub_i-th root with Fermat's spiral, and our encoded element is the angle theta from the origin of a line segment to this point.

Decryption happens in the reverse fashion, finding the root of Fermat's spiral which lies N(i mod |N|) occurances of the spiral below the intersection of the spiral and a ray theta from the origin.

In the /src folder is a class implementation of this encryption, in PHP, a simple test file, and a text file showing an encrypted version of the page at https://en.wikipedia.org/wiki/Encryption, as generated by the test file, using base 10, and the mapping (0=>1, 1=>3, 2=>5, 3=>7, 4=>11, 5=>13, 6=>17, 7=>19, 8=>23, 9=>27).


Update: The array N has been added to stop the discovery of b by taking sqrt(size encrypted alphabet)
