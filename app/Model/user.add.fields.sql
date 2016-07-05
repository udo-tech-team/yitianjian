use ssserver;
 ALTER TABLE cake_users ADD reg_ip varchar(32) default NULL comment 'register ip';
 ALTER TABLE cake_users ADD uniq_md5 varchar(64) default NULL comment 'for invite, user uniq md5 str';
 ALTER TABLE cake_users ADD invite_num int default 0 comment 'the invite num of the user';
 update cake_users set  uniq_md5 = md5(concat(uid,email,created));

