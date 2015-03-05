[![Build Status](https://travis-ci.org/TOGoS/nife.svg?branch=master)](https://travis-ci.org/TOGoS/nife)

## The Nife PHP framework

Unlike many PHP MVC frameworks, Nife does not force you to code in a
brittle, badly-defined subset of PHP.  Rather, it is a set of simple
classes and interfaces that solve common problems and provide
commonly-needed abstractions in a straightforward and conventional
way.  Copy over the classes that you want, implement the interfaces
with your own backends as needed, and ignore the parts that aren't
useful to your project.

### Philosophy

- To maximize reusability, interfaces should be designed to handle a
  single use case, and provide only a single way to use them.
- Interfaces should be defined according to how they are used,
  not how they are initialized.  e.g. setXXX methods are generally
  inappropriate unless part of a storage API.
- Objects should be as stateless as possible.
  See: http://davidlesches.com/blog/a-rant-on-the-misuse-of-instance-variables
- Interfaces should not define 'convenience methods'.
  Convenience utility functions may be provided, instead.
- Don't make assumptions about the environment within which objects
  are being used.
- Don't use global state.
- Methods whose implementations are likely to be I/O bound should
  return futures.
- When practical, take advantage of language features rather than
  introducing new APIs.  This is somewhat difficult in PHP as the
  'language features' are generally pretty terrible, but e.g. clean up
  resources in __destruct() rather than having a separate close()
  method, use functions instead of single-method classes when
  their purpose is obvious enough.
  (I may change my mind about this point.)
- Follow standard naming and documentation conventions.

## Getting Started

### With Composer

If you already have a Composer-based project, add Nife to the requirements in composer.json:

```json
{
  "require": {
    "php": ">=5.2.0",
    "ryprop/nife": "~0.1.0"
  },
  "minimum-stability": "dev",
}
````

Nife comes with a program, ```bin/new-nife-project```,
that can generate a bit of boilerplate to get you started.
This will generate ```composer.json``` if it is not already present.
If you use the above ```composer.json``` example to install Nife,
delete it before running ```vendor/ryprop/nife/bin/new-nife-project```.
