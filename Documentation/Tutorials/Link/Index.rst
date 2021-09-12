.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _magic:

Magic Link Workflow
-------------------

.. rst-class:: bignums-xxl

#. Add Login plugin on an expected page.

    .. image:: ../../Images/plugin-login.png
        :class: with-shadow

#. Click on <Magic link?>.

    .. image:: ../../Images/magic_link-step-1.png
        :class: with-shadow

#. Provide email address.

    .. figure:: ../../Images/magic_link-step-2.png
        :class: with-shadow

        :ref:`Validation message <request-magic-link-email-validation>`

#. Set proper page redirect.

    When form from previous step is submitted, user is redirected to certain page.

    .. image:: ../../Images/magic_link-step-3.png
        :class: with-shadow

    * Redirect page

        .. tip::
            :ts:`plugin.tx_flogin.settings.redirect.afterMagicLinkNotificationSentPage = 3`

#. Check the email :ref:`notification <magic-link-notification>`.

    * :ref:`Common email settings <common-notification-settings>`

    * Lifetime

        By default magic link expires after 6 minutes.

        .. tip::
            :ts:`plugin.tx_flogin.settings.email.magicLink.linkLifetimeInMinutes = 30`

#. Here we go.

    After user follows the link, automatic authentication happens and user
    is redirected to the after login page.

    .. figure:: ../../Images/authenticated.png
        :class: with-shadow

        :ref:`Error redirects <common-error-redirects>`

    * After successful login redirect

        .. tip::
            :ts:`plugin.tx_flogin.settings.redirect.afterLoginPage = 15`

.. toctree::
    :hidden:

    Notification/Index
