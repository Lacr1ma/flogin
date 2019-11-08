#
# Table structure for table 'tx_login_domain_model_resets'
#
CREATE TABLE tx_login_domain_model_resets (
	user int(11) unsigned DEFAULT '0',
	token varchar(64) DEFAULT '' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,

	KEY user (user),
	KEY token (token),
	UNIQUE KEY user_token (user, token, deleted)
);

#
# Table structure for table 'tx_login_domain_model_link'
#
CREATE TABLE tx_login_domain_model_link (
	user int(11) unsigned DEFAULT '0',
	token varchar(64) DEFAULT '' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,

	KEY user (user),
	KEY token (token),
	UNIQUE KEY user_token (user, token, deleted)
);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	locked tinyint(3) unsigned DEFAULT '0' NOT NULL,

	KEY locked (locked)
);

