CREATE TABLE tx_flogin_domain_model_resets (
	user int(11) unsigned DEFAULT 0,
	token varchar(64) DEFAULT '' NOT NULL,
	deleted tinyint(1) DEFAULT 0 NOT NULL,

	KEY user (user),
	KEY token (token),
	UNIQUE KEY user_token (user, token, deleted)
);

CREATE TABLE tx_flogin_domain_model_link (
	user int(11) unsigned DEFAULT 0,
	token varchar(64) DEFAULT '' NOT NULL,
	deleted tinyint(1) DEFAULT 0 NOT NULL,

	KEY user (user),
	KEY token (token),
	UNIQUE KEY user_token (user, token, deleted)
);

CREATE TABLE fe_users (
	locked tinyint(1) unsigned DEFAULT 0 NOT NULL,

	KEY email (email),
	KEY locked (locked),
	UNIQUE KEY email_unique (email, pid)
);
