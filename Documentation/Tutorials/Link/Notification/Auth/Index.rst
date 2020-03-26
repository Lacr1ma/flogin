.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _magic-link-notification:

Magic Link Notification
=========================

    When magic link requested this notification is sent.

    .. figure:: ../../../../Images/Notification/magic-link.png
        :class: with-shadow

        Magic Link Notification

Sign in
---------

    By clicking the **Sign in** button, system authenticates
    the associated account and redirects to :ts:`afterLoginPage`.

Notification Subject
---------------------

    You can change the subject of the notification

    .. tip::

        :ts:`plugin.tx_flogin.settings.email.magicLink.subject = LLL:EXT:flogin/Resources/Private/Language/email.xlf:magic_link.subject`

View & Variables
--------------------

    * The notification view can be found under:

        :file:`EXT:flogin/Resources/Private/Templates/Email/MagicLink.html`

    * Out of the box you developer has access to these variables:

        .. figure:: ../../../../Images/Notification/magic_variables.png
            :class: with-shadow

            You can access it by: :file:`{{request}}`, like :file:`{{request.user.username}}`

        .. figure:: ../../../../Images/Notification/magic_variables-url.png
            :class: with-shadow

            You can access link url by :file:`{{request.url}}`.

        .. figure:: ../../../../Images/Notification/magic_variables-expires.png
            :class: with-shadow

            You can access **linkLifetimeInMinutes** by: :file:`{{request.expires}}`.
