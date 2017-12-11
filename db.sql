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

CREATE TABLE `shop_admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `is_use` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用  1：启用 0：禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `shop_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类的ID，0：代表顶级',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类表';

CREATE TABLE `shop_admin_role` (
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理员的ID',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色的ID'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';



CREATE TABLE `shop_privilege` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(10) NOT NULL COMMENT '模块名称',
  `controller_name` varchar(10) NOT NULL COMMENT '控制器名称',
  `action_name` varchar(10) NOT NULL COMMENT '方法名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类的ID，0：代表顶级权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='权限表';

CREATE TABLE `shop_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

CREATE TABLE `shop_role_privilege` (
  `pri_id` smallint(5) unsigned NOT NULL COMMENT '权限的ID',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色的ID'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色权限表';

