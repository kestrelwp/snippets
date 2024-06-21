Welcome! This repo contains code snippets from the Kestrel team. We're also happy to accept community contributions for snippets you find useful related to our plugins or WooCommerce generally.

- the `woo-extensions` directory has snippets related to Kestrel's [WooCommerce extensions](https://kestrelwp.com/go/woo/)
- the `woo-core` directly has general WooCommerce snippets we've found useful or written about

You can copy the `template-snippet.php` in the root directory to get going.

If you want to use any of these snippets on your site, please be sure you follow our guide to [safely add custom code to WooCommerce](https://kestrelwp.com/blog/add-custom-code-to-woocommerce/).

## Contributing

- If you see a problem with a code snippet (e.g. it's outdated), we welcome pull requests! New snippets are also welcome &mdash; we'd appreciate it if you include a brief description of what the snippet does in your PR or the code comments in the snippet file.
- Submitted code should follow [WordPress code standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) and conventions.
- Let's be kind to folks finding these snippets: please ensure PHP 7.4 compatibility, as a lot of WordPress sites still use older PHP versions. If your snippet requires a specific WooCommerce version, let's at minimum note in code comments (ideally, put a version check in your code!).
- Feel free to use closures; if you name a function, ideally it should have a "false namespace" to avoid conflicts. We use `kwp_`, like `kwp_my_function()`, which can be used for submissions.

## Licensing

All code in this repository is licensed under the GPL (GNU General Public License v3.0). Please note that your contributions will adopt this license.