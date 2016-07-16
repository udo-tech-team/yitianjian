use ssserver;
create table if not exists cake_lines (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `acclevel` varchar(256) DEFAULT NULL COMMENT 'account level, eg basic/middle/high',
      `created` datetime DEFAULT NULL,
      `modified` datetime DEFAULT NULL,
      `country` varchar(256) DEFAULT NULL COMMENT 'en country name like America',
      `country_cn` varchar(256) DEFAULT NULL COMMENT 'cn country name',
      `city` varchar(256) DEFAULT NULL COMMENT 'en city name like Los Angeles',
      `city_cn` varchar(256) DEFAULT NULL COMMENT 'cn city name',
      `monthly_price` int unsigned not null default 0 COMMENT 'monthly price ',
      `domains` varchar(128) not null default '' COMMENT 'coresponding domains',
      `status` int unsigned not null default 0 COMMENT '0 means this line is available, 1 means not enough available ports',

      PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

insert into cake_lines (acclevel, created, modified, country, country_cn, city, city_cn, monthly_price, domains) values ('basic', now(), now(), 'America', '美国', 'Los Angeles', '洛杉矶', 300, 'gso.hk');
insert into cake_lines (acclevel, created, modified, country, country_cn, city, city_cn, monthly_price, domains) values ('basic', now(), now(), 'America', '美国', 'Sillycon Valley', '硅谷', 300, 'uwill.pw');
insert into cake_lines (acclevel, created, modified, country, country_cn, city, city_cn, monthly_price, domains) values ('basic', now(), now(), 'America', '日本', 'Tokyo', '东京', 300, 'umay.pw');
