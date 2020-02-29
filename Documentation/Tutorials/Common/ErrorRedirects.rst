.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _common-error-redirects:

Error Redirects
----------------

    During authentication process some expected errors could occur.
    In this section we mention these errors.

Expired token
===============

    .. rst-class:: horizbuttons-striking-m

    - magic link
    - forgot password

    Usually tokens inside notifications have a certain lifetime.
    That way we can assume the links could be expired when user
    did not use the link in time.

    In such a case system performs redirect to

    .. note::

        :ts:`plugin.tx_login.settings.redirect.error.whenTokenExpiredPage = X`

    .. figure:: ../../Images/Error/token_expired.png
        :class: with-shadow

        Token expired page...

Missing token
===============

    .. rst-class:: horizbuttons-striking-m

    - magic link
    - forgot password

    After the lifetime of the link is passed, - it gets expired, but still exists in the system.
    After certain amount of time scheduler task cleans all the expired links.
    Theoretically, it’s possible that user will face the situation where link has been already deleted.

    In such a case system performs redirect to

    .. note::

        :ts:`plugin.tx_login.settings.redirect.error.whenTokenNotFoundPage = X`

    .. figure:: ../../Images/Error/token_not_found.png
        :class: with-shadow

        Token was deleted page...

Already authenticated
======================

    .. rst-class:: horizbuttons-striking-m

    - magic link

    When user tries to be authenticated thought the magic link, but the active session
    already exists in browser, system performs redirect to

    .. note::

        :ts:`plugin.tx_login.settings.redirect.alreadyAuthenticatedPage = X`

    .. figure:: ../../Images/Error/already_authenticated.png
        :class: with-shadow

        Authenticated page...

User is locked
===============

    .. rst-class:: horizbuttons-striking-m

    - login form

    After brute force targeted to certain account, system usually *locks* the account.
    When someone tries to login using **Login Form**, even if the credentials are correct,
    authentication does not happen when account is locked, instead system performs redirect to

    .. note::

        :ts:`plugin.tx_login.settings.redirect.error.whenLockedPage = X`

    .. figure:: ../../Images/Error/locked.png
        :class: with-shadow

        Locked Page...

    It's worth to mention, that magic link authentication works fine even if the account is locked.
