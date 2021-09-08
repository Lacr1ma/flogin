.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _advice:

Common practise
----------------

    From project to project you probably use the same settings related to `EXT:flogin`.
    This page collects all the common settings and practices that will simplify
    some things.

Page Tree
=============

    For every project that uses authentication based on `EXT:flogin` we usually
    create a page tree that contains mostly all of the pages which build a
    nice user experience.

    .. figure:: ../../Images/page_tree.png
        :class: with-shadow

        Page Tree of the `EXT:flogin` related pages.

TypoScript Setup
=================

    Either way, we need to initialize certain variables to make the extension work.
    Usually, we copy this example configuration and place inside the **theme** extension.

    Use it, just replace with your actual variables.

    .. code-block:: ts

        plugin.tx_routes.settings.redirect.loginPage = 2

        plugin.tx_flogin.settings {
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

        Scheduler tasks related to `EXT:flogin`.


Handle translations
===================

    In situations when you need to overwrite the default language labels,
    you can use this TypoScript snippets in your theme extension.

    .. code-block:: ts

        plugin.tx_flogin._LOCAL_LANG {

            ########################
            ###### LOGIN FORM ######
            ########################

            # Username
            default.username.label       = Username
            default.username.placeholder = Input your username...

            # Password
            default.password.label       = Password
            default.password.placeholder = Input your password...

            # Remember me checkbox
            default.remember.label = Remember me

            # Forgot link
            default.forgot.link = Forgot password ?

            # Magic link
            default.magic.link = Magic link?

            # Submit button
            default.form_login.submit = Login

            # Logout button
            default.form_login.logout = Logout



            ########################
            #### CHANGE PASSWORD ###
            ########################

            # New password input
            default.password.new.label              = New password

            # Confirm new password input
            default.password.new_confirmation.label = Confirm new password

            # Submit button
            default.form_reset.submit = Change password



            #########################
            ## FORGOT PASS REQUEST ##
            #########################

            # Submit button
            default.form_forgot.submit = Send the link




            ########################
            ## MAGIC LINK REQUEST ##
            ########################

            # Submit button
            default.form_magic.submit = Send magic link



            ########################
            ###### VALIDATION ######
            ########################

            # Login Form
            default.username.locked                 = User has been locked
            default.username.not_found              = Provided username is not found.
            default.password.not_match              = Password is invalid
            default.login.limit_reached             = Too much request! Please wait for %s minutes

            # Magic link | Forgot password
            default.email.not_found                 = This email address is not connected to any user in our system.

            # Magic link
            default.user.already_logged_in          = User is already authenticated

            # Reset Password
            default.password_confirmation.not_match = Confirmation password does not match



            ########################
            ######## COMMON ########
            ########################

            # Email (request magic link, forgot password request)
            default.email.label                = Email address
            default.email.placeholder          = Input your email address...

            # Async login form
            default.ajax.loading               = Loading...
            default.ajax.redirect              = Redirecting...
            default.ajax.notification_sent     = Notification has been sent successfully.

            # Backend module
            default.temporary_account.generate = Generate temporary account
        }

    For other languages just replace the :file:`default` with actual key. ( Like :file:`de` ).
