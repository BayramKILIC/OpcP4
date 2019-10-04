# OpcP4

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/72a88f1f6cdb4f04af2826dfa7f21eae)](https://www.codacy.com/manual/BayramKILIC/OpcP4?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=BayramKILIC/OpcP4&amp;utm_campaign=Badge_Grade)

Billeterie du Louvre (OC)
========================


Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].

Installation
------------
Clone this repository

```bash
$ git clone https://github.com/BayramKILIC/OpcP4.git louvre
```

Usage
-----

There's no need to configure anything to run the application. If you have
installed the [Symfony client][4] binary, run this command to run the built-in
web server and access the application in your browser at <http://localhost:8000>:

```bash
$ cd louvre/
$ symfony serve
```

If you don't have the Symfony client installed, run `php bin/console server:run`.
Alternatively, you can [configure a web server][3] like Nginx or Apache to run
the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd louvre/
$ ./bin/phpunit
```

[1]: https://symfony.com/doc/current/best_practices/index.html
[2]: https://symfony.com/doc/current/reference/requirements.html
[3]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[4]: https://symfony.com/download