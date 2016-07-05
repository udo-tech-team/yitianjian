use ssserver;
create table if not exists cake_vouchers (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `md5str` varchar(64) DEFAULT NULL COMMENT 'uid+uname+time+ip md5 output string to mark a voucher',
    `uid` int(10) unsigned NOT NULL COMMENT 'the voucher owner',
    `from_uid` int(10) unsigned NOT NULL COMMENT 'from which user, the owner gets the voucher',
      `get_from` int unsigned not null default 0 COMMENT '1 means get from inviting others, 2 means get from register',
      `created` datetime DEFAULT NULL,
      `modified` datetime DEFAULT NULL,
      `expire` datetime DEFAULT NULL,
    `amount` int unsigned NOT NULL default 0 COMMENT 'the amount of money in cents',
      `is_valid` int unsigned not null default 0 COMMENT '0 means not valid(already used), 1 means valid',

      PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

