# Contribute to this extension

For help about contributing to the documentation in general, see https://docs.typo3.org/typo3cms/HowToDocument/

You are welcome to contribute to this example extension. Please note that the code is used in different manuals
to demonstrate certain features of TYPO3 and Extbase.

Talk to us on Slack, channel #typo3-documentation or open an [issue](https://github.com/TYPO3-Documentation/blog_example/issues) to be sure
that your intended changes are fitting the didactics of these manuals.

## Run tests and apply coding guidelines

The blog-example comes with a simple demo set of tests. It relies
on the runTests.sh script which is a simplified version of a similar script from the TYPO3 core.
Find detailed usage examples by executing `Build/Scripts/runTests.sh -h` and have a look at
`.github/workflows/tests.yml` to see how this is used in CI.

Install the requirements:

```
    make install
```

Apply rector and automatic coding guideline fixes:

```
    make fix
```

Run tests:

```
    make test
```

See help:

```
    make
```

If you have no `make` installed or which for finer control, you can run the tests directly:

```
    Build/Scripts/runTests.sh -s h
```

# General TYPO3 Support

If you have some general TYPO3 support questions or need help with TYPO3, please see https://typo3.org/help.
