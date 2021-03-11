# Ministry of Education Silverstripe Core

Stores the basic data types and functionality that should be present on any
website managed by MoE. This module installs the required Silverstripe modules
for CWP and other third-party modules + extensions which make Silverstripe
shine.

> :green_heart: **Note that this doesn't require CWP to function**. It can be
used on any non CWP / SS Platform hosting.

## What this doesn't include

This module does not include front-end styles, pagetypes or anything like that instead, 
this module is focused on the backend functionality and performance. 

For generic front-end styles and things like standard `education.govt.nz` footer 
check out the `standard-header` module or use the `silverstripe-ds` module for our 
new Design System implemented in Silverstripe.

## Features

### Base Functionality

All core, search, queued jobs and helpful additions such as TinyMCE improvements.

### Reports

Any editor can run the same generic reports across all our sites.

### Secure by default

Built-in CSP rules via the `SecuredControllerExtension` these rules can be
extended if needed.

### Consistently good SEO

SEO metadata for consistent editing and tools for achieving best results.

### Developer UX

Standard helpers such as `ArrayHelper`, `StringHelper` and extensions to Silverstripe
(such as `$Date.FormatPHP(d/m/Y)`)

## How-to

### Build assets

```
cd /vendor/education/cwp-core/
npm i
npm run build
```

## See also

-   [Design System](https://github.com/education-nz/silverstripe-ds)
-   [Header](https://github.com/education-nz/standard-header)
-   [Footer](https://github.com/education-nz/standard-footer)

## Copyright

Copyright 2021 All Rights Reserved Ministry of Education, NZ.
