[![Latest Stable Version](https://poser.pugx.org/t3docs/blog-example/v/stable.svg)](https://extensions.typo3.org/extension/blog_example/)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-13-orange.svg?style=flat-square)](https://get.typo3.org/version/13)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-12-orange.svg?style=flat-square)](https://get.typo3.org/version/12)
[![Total Downloads](https://poser.pugx.org/t3docs/blog-example/d/total.svg)](https://packagist.org/packages/t3docs/blog-example)
[![Monthly Downloads](https://poser.pugx.org/t3docs/blog-example/d/monthly)](https://packagist.org/packages/t3docs/blog-example)
![Build Status](https://github.com/TYPO3-Documentation/blog_example/actions/workflows/tests.yml/badge.svg)

# TYPO3 extension ``blog_example``

**Installation:** Can be installed via Composer:
``composer req t3docs/blog-example``

This example provides the code examples for [Extbase reference] (https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ExtensionArchitecture/Extbase/Reference/Index.html#extbase-reference)
of the TYPO3 project.

The code examples are automatically extracted with the TYPO3 documentation
code-snippet tool (https://github.com/TYPO3-Documentation/t3docs-codesnippets)

After changes to the code the snippets in the TYPO3-Reference-CoreApi
have to be regenerated.

```
ddev exec vendor/bin/typo3  restructured_api_tools:php_domain public/fileadmin/TYPO3CMS-Reference-CoreApi/Documentation/CodeSnippets/
```

It was originally written by Sebastian Kurfuerst and Jochen Rau (Thanks!) and
adjusted over time to reflect current development in the TYPO3 project.

|                  | URL                                                  |
|------------------|------------------------------------------------------|
| **Repository:**  | https://github.com/TYPO3-Documentation/blog_example  |
| **TER:**         | https://extensions.typo3.org/extension/blog_example/ |

# Running tests

Please see [CONTRIBUTING.md](CONTRIBUTING.md)


# Tagging and releasing

[packagist.org](https://packagist.org/packages/t3docs/blog-example) is enabled via the casual GitHub hook.
TER releases are created by the "publish.yml" GitHub workflow when tagging versions.
The commit message of the tagged commit is used as TER upload comment.
