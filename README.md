[![Latest Stable Version](https://poser.pugx.org/friendsoftypo3/blog-example/v/stable.svg)](https://extensions.typo3.org/extension/blog_example/)
[![TYPO3 10](https://img.shields.io/badge/TYPO3-10-orange.svg?style=flat-square)](https://get.typo3.org/version/10)
[![Total Downloads](https://poser.pugx.org/friendsoftypo3/blog-example/d/total.svg)](https://packagist.org/packages/friendsoftypo3/blog-example)
[![Monthly Downloads](https://poser.pugx.org/friendsoftypo3/blog-example/d/monthly)](https://packagist.org/packages/friendsoftypo3/blog-example)

# TYPO3 extension ``blog_example``

This example is part of the [Extbase documentation](https://docs.typo3.org/m/typo3/book-extbasefluid/main/en-us/)
of the TYPO3 project.

It was originally written by Sebastian Kurfuerst and Jochen Rau (Thanks!) and
adjusted over time to reflect current development in the TYPO3 project.

|                  | URL                                                  |
|------------------|------------------------------------------------------|
| **Repository:**  | https://github.com/FriendsOfTYPO3/blog_example       |
| **TER:**         | https://extensions.typo3.org/extension/blog_example/ |

# Running tests

The blog-example comes with a simple demo set of tests. It relies
on the runTests.sh script which is a simplified version of a similar script from the TYPO3 core.
Find detailed usage examples by executing `Build/Scripts/runTests.sh -h` and have a look at
`.github/workflows/tests.yml` to see how this is used in CI.

Example usage:

```
Build/Scripts/runTests.sh -s composerUpdate
Build/Scripts/runTests.sh -s unit
```

# Normalize composer.json

```
Build/Scripts/runTests.sh -s composerNormalize -n
```

