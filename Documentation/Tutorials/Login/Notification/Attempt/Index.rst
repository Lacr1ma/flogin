.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

Login Attempt
==============

    System sends the email notification to the user after successful login attempt.

    .. image:: ../../../../Images/Notification/logged_in.png
        :class: with-shadow

Change password
---------------------------

    At some point, there's a chance that someone else logged in to the account
    without any owner permission and awareness.

    By clicking the **Change password** button,
    the reset password procedure will be started.

    Email will be predefined already, and the next steps are the same
    comparing to **Reset Password** feature.

    .. figure:: ../../../../Images/forgot-predefined.png
        :class: with-shadow

        Reset password page...

Notification Subject
---------------------

    You can change the subject of the notification

    .. tip::

        :ts:`plugin.tx_flogin.settings.email.login.subject = LLL:EXT:flogin/Resources/Private/Language/email.xlf:login.subject`

Disable the notification
-------------------------

    It's possible to completely disable the notification by changing the TypoScript
    variable.

    .. tip::

        :ts:`plugin.tx_flogin.settings.email.login.disabled = 1`

View & Variables
--------------------

    * The notification view can be found under:

        :file:`EXT:flogin/Resources/Private/Templates/Email/Login.html`

    * Out of the box you developer has access to these variables:

        .. figure:: ../../../../Images/Notification/login_variables.png
            :class: with-shadow

            You can access it by: :file:`{{user}}`, like :file:`{{user.username}}`

        .. figure:: ../../../../Images/Notification/login_variables-1.png
            :class: with-shadow

            You can access it by: :file:`{{request}}`, like :file:`{{request.SERVER_ADDR}}`
