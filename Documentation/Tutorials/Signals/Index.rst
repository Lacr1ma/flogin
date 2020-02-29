.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _signal-collection:

Signals collection
-------------------

    Register the class which implements your logic in `ext_localconf.php`:

Password reset link requested.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'sendResetLinkRequest',
            \MY\ExtKey\Slots\ResetLinkRequested::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\Request\ResetPasswordRequest $request`

Password has been reset.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'passwordHasBeenReset',
            \MY\ExtKey\Slots\PasswordUpdated::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\Request\ResetPasswordRequest $request`

Magic link requested.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'sendMagicLinkRequest',
            \MY\ExtKey\Slots\MagicLinkRequested::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\Request\MagicLinkRequest $request`

Magic link applied.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'magicLinkApplied',
            \MY\ExtKey\Slots\MagicLinkApplied::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`string $token`

Account has been locked out.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'lockout',
            \MY\ExtKey\Slots\LockoutHappened::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\User $user`

Account has been unlocked.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'userUnlocked',
            \MY\ExtKey\Slots\AccountUnlocked::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\User $user`

Login attempt detected.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'loginAttempt',
            \MY\ExtKey\Slots\NewLoginAttempt::class,
            'handle'
        );

    The method is called with the following arguments:

    * :php:`\LMS\Login\Domain\Model\User $user`
    * :php:`string                       $plainPassword`
    * :php:`bool                         $remember`

Failed login attempt detected.
==============================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'loginAttemptFailed',
            \MY\ExtKey\Slots\NewFailedLoginAttempt::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`string $username`

Successful login attempt detected.
===================================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'loginSuccess',
            \MY\ExtKey\Slots\NewSuccessfulLoginAttempt::class,
            'handle'
        );

    The method is called with the following arguments:

    * :php:`\LMS\Login\Domain\Model\User $user`
    * :php:`bool                         $remember`

Logout detected.
=================

    .. code-block:: php

        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \LMS\Login\Event\SessionEvent::class,
            'logoutSuccess',
            \MY\ExtKey\Slots\UserLoggedOut::class,
            'handle'
        );

    The method is called with the following argument:

    * :php:`\LMS\Login\Domain\Model\User $user`
