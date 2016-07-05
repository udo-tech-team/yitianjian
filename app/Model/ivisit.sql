use ssserver;
create table if not exists cake_ivisits (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `invite_md5` varchar(64) DEFAULT NULL COMMENT 'request param from register page',
    `req_ip` varchar(32) DEFAULT NULL comment 'request client ip',
    `created` datetime DEFAULT NULL,

      PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

