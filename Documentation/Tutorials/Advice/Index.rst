.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _advice:

Common practise
----------------

    From project to project you probably use the same settings related to `EXT:login`.
    This page collects all the common settings and practices that will simplify
    some things.

Page Tree
=============

    For every project that uses authentication based on `EXT:login` we usually
    create a page tree that contains mostly all of the pages which build a
    nice user experience.

    .. figure:: ../../Images/page_tree.png
        :class: with-shadow

        Page Tree of the `EXT:login` related pages.

TypoScript Setup
=================

    Either way, we need to initialize certain variables to make the extension work.
    Usually, we copy this example configuration and place inside the **theme** extension.

    Use it, just replace with your actual variables.

    .. code-block:: ts

        plugin.tx_routes.settings.redirect.loginPage = 2

        plugin.tx_login.settings {
            page.login = 2

            oneTimeAccount {
                lifetimeInMinutes = 60
                properties.usergroup = 1,2
            }

            redirect {
                afterLoginPage = 5
                afterLogoutPage = 12
                afterUnlockedPage = 16
                alreadyAuthenticatedPage = 425
                afterMagicLinkNotificationSentPage = 14
                afterResetPasswordFormSubmittedPage = 11
                afterForgotPasswordNotificationSentPage = 7

                error {
                    whenLockedPage = 15
                    whenTokenExpiredPage = 9
                    whenTokenNotFoundPage = 10
                    whenOneTimeAccountHashNotFoundPage = 426
                }
            }

            throttling {
                maxAttempts = 5
                decayMinutes = 1
                lockIntervalInMinutes = 10
            }

            email {
                site = https://example.com
                logoPath = EXT:myext/Resources/Public/Icons/Logo.svg

                magicLink.linkLifetimeInMinutes = 6
                passwordResetRequest.linkLifetimeInMinutes = 5
                login.disabled = 0
            }

        }

Clean up
=============

    We highly recommend to use scheduler tasks in your project to clean all junk
    from time to time.

    .. figure:: ../../Images/scheduler.png
        :class: with-shadow

        Scheduler tasks related to `EXT:login`.
