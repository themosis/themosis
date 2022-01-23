# Contributing

- [Introduction](#introduction)
- [Reporting Issues](#reporting-issues)
- [New Features](#new-features)
- [Which Branch?](#which-branch)
- [Security Vulnerabilities](#security-vulnerabilities)

## Introduction

Themosis is an open-source project and anyone can contribute to it. Themosis contains multiple repositories and they're all stored on Github.

If you feel confident writing code, we have 4 repositories handling the different parts of the framework:

- [themosis/themosis](https://github.com/themosis/themosis): application skeleton providing full code structure for a collaborative development, installing the latest WordPress version, dependencies and a default theme.
- [themosis/framework](https://github.com/themosis/framework): framework core containing all APIs.
- [themosis/theme](https://github.com/themosis/theme): theme boilerplate for developing your application front-end.
- [themosis/plugin](https://github.com/themosis/plugin): plugin boilerplate for developing custom plugins.

For each of these repositories, you can accordingly report any **code issues** you may find or provide pull requests.

> Please make sure to double-check before posting a code issue. All framework code issues should be reported on the [themosis/framework](https://github.com/themosis/framework) repository only.

We also need help on the documentation. If you see grammar typos or think the docs are lacking some explanation or examples, feel free to complete it:

- [themosis/documentation](https://github.com/themosis/documentation)

## Reporting Issues

Regarding code issues, please submit your code with the request and give detailed explanations about what you're trying to achieve.

We highly encourage you to send pull requests with the bug fix. Make sure to work on the latest stable release and not the `main` branch. The framework version 2.0.* has a `2.0` branch from which you have to write your pull request for. 

> A pull request **must have unit tests** along your code.

## New Features

You can make feature proposal on the [themosis/framework](https://github.com/themosis/framework) repository by opening a new issue and by assigning it the `feature` tag. 

> Please make sure to add the `feature` tag to your request or we won't look at it.

If your proposal is a good fit, you can submit a pull request with the new functionality and its unit tests:

1. **Minor** features or enhancements should be sent to the latest stable branch.
2. **Major** features should always be sent to the `main` branch which contains the code for the next release.

## Which Branch?

All bug fixes should be sent to the latest stable branch. Bug fixes should never be sent to the `main` branch unless they fix features that exist only in the upcoming release.

**Minor** features, that are fully backwards compatible with the current release, must be sent to the latest stable branch.

**Major** features should always be sent to the `main` branch, which contains the upcoming release.

## Security Vulnerabilities

If you discover a security vulnerability within the Themosis framework, please send an e-mail at [support@themosis.com](mailto:support@themosis.com). All security vulnerabilities will be promptly addressed.
