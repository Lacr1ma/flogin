# TYPO3 Extension ``login`` [![Build Status](https://travis-ci.org/Lacr1ma/login.svg?branch=master)](https://travis-ci.org/Lacr1ma/login)

This extension provides an authentication option for website users.

It’s an alternative version for managing any frontend login attempts.

Features:

* Authentication via magic link.
* Lockout user while brute force.
* Attempt to create a temporary frontend account in a BE.
* Customizable throttle tracking.
* Out of the box notifications for important actions ( password reset, password update, login, lockout, magic link usage).
* Customizable Login Form as it’s now 100% based on extbase/fluid.
* API endpoints that could be used for REST authentication.
