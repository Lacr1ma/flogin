.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:


Throttle
===========

    After every credentials submit, system tracks that event and associates the
    attempt with REQUEST IP.

    It's possible to set a maximum attempts count for every unique IP address per defined time interval.

    When all attempts are used, - validation message will be rendered and
    another attempt is not longer possible.

    When defined block time passes, user will be able to
    perform another request.

    .. figure:: ../../../Images/Error/throttle.png
        :class: with-shadow

        Notification when all possible attempts have been used...

Attempts Count
---------------

    It's possible to increase/decrease the amount of failed attempts
    just by changing the variable. By default it's 5.

    .. tip::

        :ts:`plugin.tx_login.settings.throttling.maxAttempts = 5`

Block interval
---------------

    IP address get's blocked for 1 minute by default.
    So after this amount of time it's possible to do another :file:`maxAttempts`.

    You can increase the waiting time time:

    .. tip::

        :ts:`plugin.tx_login.settings.throttling.decayMinutes = 1`

Notification
---------------

    System also locks the associated user account to protect.

    That's why :ref:`notification <lockout-notification>` message is sent.

Tweak a validation message
---------------------------

    * Validation text is stored under

        .. tip::

            :ts:`LLL:EXT:theme/Resources/Private/Language/locallang.xlf:login.limit_reached`
