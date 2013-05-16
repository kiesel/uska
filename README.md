USKA
===

United Schlund Karlsruhe Team Website

Common Tasks
---

### Packaging
This project uses Maven for building and packaging, so just

```sh
$ mvn package
```

### Installation

1. Check version in `pom.xml`
2. Make sure, same version is in top of `Makefile` - if not, register it there
   (This should be improved to automatically read the current version from `pom.xml`)
3. Run

```sh
$ mvn package
```

4. To install on stage, run:

```sh
$ make install.stage
```

5. To install productively, run:

```sh
$ make install.real
```