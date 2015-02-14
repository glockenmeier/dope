DG's Object-oriented Plugin Extension for WordPress (DOPE)
==========================================================

[![Join the chat at https://gitter.im/glockenmeier/dope](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/glockenmeier/dope?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Features:

* Provides object-oriented abstractions for Plugin, CustomPostType, Metabox, Shortcode and the like.
* Abstractions around several WordPress API's such as Transient, Options, Settings, etc.
* Features the use of MVC pattern in creating plugins. See DopeController & DopeView classes.
* Faster plugin creation using well defined interfaces and base classes.
* Standardized directory structure for plugins. (plugin-dir, model,view,controller,css)
* Autoloader for plugin that follows the standard directory structure (using spl autoloader).
* Collection classes. Provides java like iterators, convenient for use in template files.

For usage examples visit:

 * [dg-syntaxhighlighter](https://github.com/glockenmeier/dg-syntaxhighlighter)
