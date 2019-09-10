# GenericApi

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

## Usage

[Getting Started](/rafrsr/generic-api/wiki/Getting-Started)
