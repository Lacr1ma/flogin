.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.
.. _lockout-notification:

Password has been changed
===========================

    After any password changing action, - system sends notification to the associated user.

    .. figure:: ../../../../Images/Notification/password_changed.png
        :class: with-shadow

        Password changed notification.

Restore Action
-----------------

    By clicking the **Restore password** button,
    the reset password procedure will be started again, but email will be predefined.

    .. figure:: ../../../../Images/forgot-predefined.png
        :class: with-shadow

        Reset password page...

Notification Subject
---------------------

    You can change the subject of the notification

    .. tip::

        :ts:`plugin.tx_flogin.settings.email.passwordUpdated.subject = LLL:EXT:flogin/Resources/Private/Language/email.xlf:update_password.subject`

View & Variables
--------------------

    * The notification view can be found under:

        :file:`EXT:flogin/Resources/Private/Templates/Email/Password/Changed.html`

    * Out of the box you developer has access to these variables:

        .. figure:: ../../../../Images/Notification/lockout_variables.png
            :class: with-shadow

            You can access it by: :file:`{{user}}`, like :file:`{{user.username}}`
