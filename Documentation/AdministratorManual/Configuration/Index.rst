.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _ts:

TypoScript
==========

Settings
^^^^^^^^^^

.. container:: ts-properties

	======================================================== ============================================================================================= ============== ===============
	Property                                                 Title                                                                                         Sheet          Type
	======================================================== ============================================================================================= ============== ===============
	page.login                                               Page where login form plugin located.                                                         Page           int
	redirect.afterLoginPage                                  PID, that user is redirected to after successful logic attempt.                               Redirect       int
	redirect.afterLogoutPage                                 PID, that user is redirected to after logout process.                                         Redirect       int
	redirect.afterUnlockedPage                               PID, that user is redirected to after unlocking.                                              Redirect       int
	redirect.alreadyAuthenticatedPage                        PID, that user is redirected to when already being authenticated.                             Redirect       int
	redirect.afterForgotPasswordNotificationSentPage         PID, that user is redirected to after <Forgot Notification> has been sent.                    Redirect       int
	redirect.afterResetPasswordFormSubmittedPage             PID, that user is redirected to after <Forgot Form> has been submitted.                       Redirect       int
	redirect.afterMagicLinkNotificationSentPage              PID, that user is redirected to after <ML Notification> has been sent.                        Redirect       int
	redirect.error.whenTokenExpiredPage                      PID, that user is redirected to when attempts to use already expired token from notification. Redirect       int
	redirect.error.whenTokenNotFoundPage                     PID, that user is redirected to when attempts to use not existing token.                      Redirect       int
	redirect.error.whenLockedPage                            PID, that user is redirected to after successful logic attempt, when user already locked.     Redirect       int
	redirect.error.whenOneTimeAccountHashNotFoundPage        PID, that user is redirected to when one time account link is invalid.                        Redirect       int
	throttling.maxAttempts                                   Number of allowed failed login attempts. When no more attempts allowed, user will be locked.  Throttling     int
	throttling.decayMinutes                                  Block Timeout in minutes for IP after using all of request attempts.                          Throttling     int
	throttling.lockIntervalInMinutes                         After defined number of minutes, user will be automatically unlocked by scheduler.            Throttling     int
	oneTimeAccount.properties.usergroup                      One Time user can be initialized with provided list of groups.                                OneTimeAccount string (comma)
	oneTimeAccount.lifetimeInMinutes                         After defined number of minutes, user will be deleted.                                        OneTimeAccount int
	email.magicLink.subject                                  Translation file path with key, that contains subject for magic link notification.            Email          string
	email.magicLink.linkLifetimeInMinutes                    When defined number of minute has passed, magic link is considered as expired.                Email          int
	email.passwordResetRequest.subject                       Translation file path with key, that contains subject for forgot password notification.       Email          string
	email.passwordResetRequest.linkLifetimeInMinutes         When defined number of minute has passed, password reset link is considered as expired.       Email          int
	email.passwordUpdated.subject                            Translation file path with key, that contains subject for password update notification.       Email          string
	email.lockout.subject                                    Translation file path with key, that contains subject for lockout notification.               Email          string
	email.login.disabled                                     Do not send the successful login attempt notification when deactivated.                       Email          boolean
	email.login.subject                                      Translation file path with key, that contains subject for login attempt notification.         Email          string
	email.site                                               Used inside the bottom area of the mail. Basically link to owner website.                     Email          string
	email.logoPath                                           Full path to the logo image.                                                                  Email          string
	email.stylesPath                                         Full path to the css file that should be connected in email.                                  Email          string
	======================================================== ============================================================================================= ============== ===============
