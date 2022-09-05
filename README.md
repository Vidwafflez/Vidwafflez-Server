# Vidwafflez Monorepo
**Copyright (c) 2022 Vidwafflez GK. All rights reserved.**

Welcome to the Vidwafflez monorepo. This contains all files you will possibly want to edit as any developer or contributor to the project.

# Releasing source code

**We do not permit the release of source code, without prior permission, or indication within a header file.** This applies to all aspects of the respository. If you wish to release source code, please contact [Taniko Yamamoto](mailto:kirasicecreamm@gmail.com) or another senior developer to ask for permission.

This policy is in place in order to ensure user privacy and to maintain **security through obscurity** (STO) measures remain in place.

Production secret keys shall not be distributed through this repository.

# Commit format

Within your commit titles, please include the name of the component you modified in brackets near the front. As an example:

```
[frontend/www/css] Fixed displaced position in Safari.
```

As long as it's reasonable, you can refer to a larger project within the name. This is useful if you make multiple changes, such as adding a feature to the frontend which would require changes across the HTML templates, JS source code, and CSS stylesheets.

```
[frontend/www] Added recommended content box.
```

# Branch format

All code changes you make must be done in a separate branch of this monorepo. Commits made directly to `main` or `staging` without prior approval from a senior developer will be rejected. Instead, please use the `dev` branch and make a pull request (PR) for other developers to push things through the pipeline.

Changes made in the `dev` will be pushed to the `staging` branch for testing, then to the `main` branch if they are approved.

Rather than using a million different branches, it's up to you whether you want to use `dev` or your own unique development branch for a feature.

# Setting up

Depending on which portion of the site you are working on, you may have wildly different setup processes.

As usual, clone the repo and checkout the `dev` branch to get started.

## Hosting the server

The server requires:

- PHP 7.4+
- MySQL

XAMPP is an easy to setup environment that contains these two prerequisites.

You will need to configure private keys (inside the `inc/` folder).

Then you need to configure Apache virtual hosts to setup subdomains.