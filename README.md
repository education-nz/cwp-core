# Ministry of Education Silverstripe Core

Stores the basic data types and functionality that should be present on any
website managed by MoE. This module installs the required SilverStripe CWP
modules and common modules + extensions.

> :green_heart: **Note that this doesn't require CWP to function**. It can be
used on any non CWP / SS Platform hosting.

Please note that while some of our websites share design assets (such as
education.govt.nz and gazette.govt.nz) not all sites share this style. In these
cases they normally build off the `education-core` module. `education-core`
module provides standard fonts etc for ministry branding.

## Used on

 * https://www.education.govt.nz/
 * https://parents.education.govt.nz/
 * https://gazette.education.govt.nz/
 * https://evaluationhub.education.govt.nz/
 * https://connections.education.govt.nz/
 * https://youthguarantee.education.govt.nz/

## What this doesn't include

This module does not include front-end styles, pagetypes or anything like that
at this stage. This module is focused on the backend. For generic front-end
styles and things like standard `education.govt.nz` footer check out the
`education-core` module or use the `silverstripe-ds` module for our new
Design System implemented in Silverstripe.

## Features

### Standard Base

All core, search, queued jobs and helpful additions such as TinyMCE improvements

### Reports

Any editor can run the same generic reports across all our sites.

### Secure by default

Built-in CSP rules via the `SecuredControllerExtension` these rules can be
extended if needed.

### Consistently good SEO

SEO metadata for consistent editing and tools for achieving best results.

## How-to

### Build assets

```
cd /vendor/education/cwp-core/
npm i
npm run build
```

## See also

-   [Design System](https://github.com/education-nz/silverstripe-ds)

## Copyright

Copyright 2020 All Rights Reserved Ministry of Education, NZ.
