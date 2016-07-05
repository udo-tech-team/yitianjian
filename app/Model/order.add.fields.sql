use ssserver;
 ALTER TABLE cake_orders ADD line_id int unsigned default 0 comment 'port line id, when user buy new port, this field will record line id';
 ALTER TABLE cake_orders ADD port_id int unsigned  default 0 comment 'port id, when renew port, this field will record port id';
 ALTER TABLE cake_orders ADD voucher_id int unsigned default 0 comment 'if an order is related with an voucher, record the voucher id';
 ALTER TABLE cake_orders ADD discount_desc varchar(64) default NULL comment 'discount decription';


