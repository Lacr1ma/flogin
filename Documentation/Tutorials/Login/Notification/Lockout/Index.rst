.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.
.. _lockout-notification:

Lockout
==============

    When certain amount of wrong login attempts is detected for certain account,
    system *locks* that account for defined period of time.

    .. image:: ../../../../Images/Notification/lockout.png
        :class: with-shadow

Unlock from notification
---------------------------

    By clicking the **Unlock now** button, user will be automatically unlocked
    and redirected to :file:`afterUnlockedPage`.

    .. figure:: ../../../../Images/unlocked.png
        :class: with-shadow

        Example of the unlocked page.

    By default the redirect page is not set, so don't forget to set it.

    .. tip::

        :ts:`plugin.tx_login.settings.redirect.afterUnlockedPage = X`

Notification Subject
---------------------

    You can change the subject of the notification

    .. tip::

        :ts:`plugin.tx_login.settings.email.lockout.subject = LLL:EXT:login/Resources/Private/Language/email.xlf:lockout.subject`

Number of wrong attempts
-------------------------

    It's possible to change the number of wrong attempts after which target user
    is locked and notified. By default it's set to **5**.

    This means attacker can make 4 wrong attempts and nothing happens,
    only on 5th account is locked and owner is notified.

    .. tip::

        :ts:`plugin.tx_login.settings.throttling.maxAttempts = 5`

Auto unlocking (scheduler)
---------------------------

    After certain amount of time scheduler unlocks the locked account.

    By default it happens after 10 minutes of being locked,
    but you can always change that behavior.

    .. tip::

        :ts:`plugin.tx_login.settings.throttling.lockIntervalInMinutes = 10`

View & Variables
--------------------

    * The notification view can be found under:

        :file:`EXT:login/Resources/Private/Templates/Email/Lockout.html`

    * Out of the box you developer has access to these variables:

        .. figure:: ../../../../Images/Notification/lockout_variables.png
            :class: with-shadow

            You can access it by: :file:`{{user}}`, like :file:`{{user.username}}`
