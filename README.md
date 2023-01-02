# What was Vidwafflez

Our idea for an alternative YouTube-like social network website. We never gave it much focus and it didn't get very far into development. Hence all the code here is open source and may be used for whatever purposes you find necessary, licences no longer applying.

# Vidwafflez Server
**Copyright (c) 2022 Vidwafflez GK. All rights reserved.**

Welcome to the Vidwafflez server monorepo. This contains all source code pertaining to the server and API.

# Releasing source code

**We do not permit the release of source code, without prior permission, or indication within a header file.** This applies to all aspects of the respository. If you wish to release source code, please contact [Taniko Yamamoto](mailto:kirasicecreamm@gmail.com) or another senior developer to ask for permission.

This policy is in place in order to ensure user privacy and to maintain **security through obscurity** (STO) measures remain in place.

Production secret keys shall not be distributed through this repository.

# Branch format

All code changes you make must be done in a separate branch of this monorepo. Commits made directly to `main` or `staging` without prior approval from a senior developer will be rejected. Instead, please use the `dev` branch and make a pull request (PR) for other developers to push things through the pipeline.

Changes made in the `dev` will be pushed to the `staging` branch for testing, then to the `main` branch if they are approved.

Rather than using a million different branches, it's up to you whether you want to use `dev` or your own unique development branch for a feature.

# Setting up

Depending on which portion of the site you are working on, you may have wildly different setup processes.

As usual, clone the repo and checkout the `dev` branch to get started.

Just cloning the repo will not suffice for a working experience. Some aspects of the server are separated into separated Git repositories, meaning you need to run this first:

```
git submodule init
```

## Hosting the server

The server requires:

- PHP 8.1+
- MySQL

XAMPP is an easy to setup environment that contains these two prerequisites.

You will need to configure private keys (inside the `config/` folder).

Then you need to configure Apache virtual hosts to setup subdomains.