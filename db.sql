use shop;
SET NAMES utf8;

CREATE TABLE IF NOT EXISTS shop_goods(
	id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	goods_name VARCHAR(45) not null COMMENT '商品名称',
	logo VARCHAR(150) not null DEFAULT '' COMMENT '商品logo',
	sm_logo VARCHAR(150) not null DEFAULT '' COMMENT '商品缩略图logo',
	price DECIMAL(10,2) not null DEFAULT '0.00' COMMENT '商品价格',
	goods_desc LONGTEXT COMMENT '商品描述',
	is_on_sale tinyint UNSIGNED not NULL DEFAULT '1' COMMENT '是否上架：1：上架，0：下架',
	is_delete TINYINT UNSIGNED not null DEFAULT '0' COMMENT '是否已经删除，1：已经删除，0：未删除',
	addtime int UNSIGNED not null COMMENT '添加时间',
	PRIMARY KEY (id),
	KEY price(price),
	KEY is_on_sale(is_on_sale),
	KEY is_delete(is_delete),
	KEY addtime(addtime)
)ENGINE = MyISAM DEFAULT CHARSET=utf8;