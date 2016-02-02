# Generic API

[![Build Status](https://travis-ci.org/rafrsr/generic-api.svg?branch=master)](https://travis-ci.org/rafrsr/generic-api)
[![Coverage Status](https://coveralls.io/repos/rafrsr/generic-api/badge.svg?branch=master&service=github)](https://coveralls.io/github/rafrsr/generic-api?branch=master)
[![Latest Stable Version](https://poser.pugx.org/rafrsr/generic-api/version)](https://packagist.org/packages/rafrsr/generic-api)
[![Latest Unstable Version](https://poser.pugx.org/rafrsr/generic-api/v/unstable)](//packagist.org/packages/rafrsr/generic-api)
[![Total Downloads](https://poser.pugx.org/rafrsr/generic-api/downloads)](https://packagist.org/packages/rafrsr/generic-api)
[![License](https://poser.pugx.org/rafrsr/generic-api/license)](https://packagist.org/packages/rafrsr/generic-api)

API Abstraction layer with mocks. Tools for creating structured SDKs or API implementations easy and following some simple guidelines.

Most APIs provide a SDK or API implementation library in parallel.
But this not always true, or simply not made in our required language (php).
For this cases is necessary implements the API from scratch.
GenericApi is solution to keep things organized and follow a similar pattern for all libraries.

## Features

- **Guzzle:** Use guzzle with psr7 for requests, responses, and streams.
- **Mocks:** Emulate request and response for test environments
- **Validation:** Symfony validations to validate a request before send any data to remote API
- **Connection Abstraction:** Only create the request, the connection is done automatically with guzzle, no more complicated curl connections.
- **Xml and Json Parser:** Can use XML and JSON parser to convert API response to objects using JMS serializer
- **Scaffolding:** Test API connection and any method using generic classes

## Installation

1. [Install composer](https://getcomposer.org/download/)
2. Execute: `composer require rafrsr/generic-api`

## Documentation

Full documentation are available on the [wiki page](https://github.com/rafrsr/generic-api/wiki)

## Functional Example

Can view a more complex example of functional API in the "sample" folder.

## Copyright

This project is licensed under the [MIT license](LICENSE).