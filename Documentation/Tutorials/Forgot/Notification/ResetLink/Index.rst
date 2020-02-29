.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _forgot-password-notification:

Reset Link Requested
=====================

    System sends the email notification to the user after submitting
    the **forgot password form**.

    .. figure:: ../../../../Images/Notification/reset-link-request.png
        :class: with-shadow

        Forgot password notification.

Lifetime
---------

    By default link inside the mail expires after 5 minutes.

    Of course you can change that behavior.

    .. tip::

        :ts:`plugin.tx_login.settings.email.passwordResetRequest.linkLifetimeInMinutes = 5`

Notification Subject
---------------------

    You can change the subject of the notification

    .. tip::

        :ts:`plugin.tx_login.settings.email.passwordResetRequest.subject = LLL:EXT:login/Resources/Private/Language/email.xlf:reset_password.subject`

View & Variables
--------------------

    * The notification view can be found under:

        :file:`EXT:login/Resources/Private/Templates/Email/Password/ResetRequest.html`

    * Out of the box you developer has access to these variables:

        .. figure:: ../../../../Images/Notification/reset-variables.png
            :class: with-shadow

            You can access it by: :file:`{{request}}`, like :file:`{{request.user.username}}`

        .. figure:: ../../../../Images/Notification/reset-variables-url.png
            :class: with-shadow

            You can access link url by :file:`{{request.url}}`.

        .. figure:: ../../../../Images/Notification/reset-variables-expires.png
            :class: with-shadow

            You can access **linkLifetimeInMinutes** by: :file:`{{request.expires}}`.
