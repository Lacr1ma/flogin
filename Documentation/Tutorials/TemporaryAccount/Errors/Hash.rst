.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _temporary-account-errors-hash:

Invalid Hash
-------------

    When link that creates a temporary frontend user is not valid,
    system performs the redirect. You can change the redirect target via TypoScript.

    .. tip::

        :ts:`plugin.tx_login.settings.redirect.error.whenOneTimeAccountHashNotFoundPage = 77`

    It's always a good choice to set the :file:`whenOneTimeAccountHashNotFoundPage`,
    even if you are positive about the situation will never happen.

    * Example of the page redirect when error occurs.

        .. image:: ../../../Images/Error/hash_invalid.png
            :class: with-shadow
