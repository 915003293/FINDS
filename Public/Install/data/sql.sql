-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-17 09:19:23
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `t31`
--

-- --------------------------------------------------------

--
-- 表的结构 `find_article`
--

CREATE TABLE IF NOT EXISTS `find_article` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  `create_time` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `posts` int(10) unsigned NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `find_article`
--

INSERT INTO `find_article` (`aid`, `tid`, `title`, `content`, `status`, `create_time`, `uid`, `posts`) VALUES
(1, 1, '第一篇文章', '&lt;div id=&quot;article&quot;&gt;\r\n		&lt;div class=&quot;article&quot;&gt;\r\n       							&lt;!--文章摘要开始--&gt;\r\n       							&lt;!--enpproperty &lt;articleid&gt;1644333&lt;/articleid&gt;&lt;date&gt;2017-04-07 10:51:21.0&lt;/date&gt;&lt;author&gt;岳霞红&lt;/author&gt;&lt;title&gt;山西在全国加快布点“山西煤仓” 改变交易方式&lt;/title&gt;&lt;keyword&gt;&lt;/keyword&gt;&lt;subtitle&gt;&lt;/subtitle&gt;&lt;introtitle&gt;&lt;/introtitle&gt;&lt;siteid&gt;2&lt;/siteid&gt;&lt;nodeid&gt;2205&lt;/nodeid&gt;&lt;nodename&gt;特别关注&lt;/nodename&gt;&lt;nodesearchname&gt;&lt;/nodesearchname&gt;/enpproperty--&gt;&lt;!--enpcontent--&gt;				&lt;!--正文开始--&gt;                   &lt;!--enpcontent--&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; 改变“现买现运”的交易方式，把“山西煤仓”建到市场终端，让用户第一时间就能用上“山西煤”；记者4月6日从中国（太原）煤炭交易中心了解到，山西省不断推进晋煤的市场化交易模式，力图依托与铁路部门签署的大额煤炭运输合同，在全国搭建起顺应用户需求、煤炭库存前移的分散式“山西煤仓”，确保客户在交易完成后，第一时间就能就近用上质高价优的山西煤。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;煤铁合作，建设“大煤仓”&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;3月31日，中国（太原）煤炭交易中心与郑州铁路局签署《2017年郑州铁路局与中国（太原）煤炭交易中心煤炭交收库铁路运输合同》（以下简称《运输合同》），双方首次签订了运量为35万吨的铁路运输合同。这是继太原铁路局与中国（太原）煤炭交易中心签订50万吨交收库运力配置合同之后，我省推进和构建“晋煤大物流”战略布局的又一重大举措。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;据了解，此次签订的《运输合同》，主要为中国（太原）煤炭交易中心在郑州铁路局业务范围内设立的三个“煤仓”服务，它们分别是枝城港交收仓库、徐州港交收仓库、新易达交收仓库，签订量分别为枝城港交收库5万吨、徐州港交收库15万吨、新易达交收库15万吨，执行期为2017年4月1日至2017年12月31日。而在此之前，交易中心已与太原铁路局签订了50万吨的运力合同，其目的也是为其设立的分散式煤炭仓库提供运力保障。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;争抢服务的“第一时间”&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;从“现买现运”到“未买先运”，反映出了我省煤炭销售的市场化蜕变。过去，我省煤炭一般都是与用户签订购销合同之后，才开始从各煤炭企业装车发货，到货时间长，还不能确保交货时间，“用户体验”一般；而现在，随着遍布全国的“山西煤仓”逐渐成形成网，用户在交付货款后，就近的煤炭仓库即可迅速发货，物流时间大大缩短，极大提高了用户购买山西煤的积极性。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;据交易中心相关专家介绍，通过中心与相关铁路局的“煤铁联合”，一是保证了铁路部门对“山西煤仓”的运力保障；二是支持了重点交易商库存前移、贴近市场，提高了对市场的灵敏度和服务性，帮助省内煤炭企业实现了库存前移、销售前移；为煤炭上下游企业提供了优质、高效精准的交易、交收、结算服务；三是交易中心与铁路合作探索确保晋煤外运的长效协作机制，实现了车尽其用、煤畅其流。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;山西煤炭的“营销之变”&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;把重心从省内移向省外，把市场从主产地移向消费地；这样的变革，不仅顺应了用户的需要，也为我省煤炭在低迷的环境中争取到了最大的市场阵地。据介绍，今后我省仍将以“省内建仓、省外建市、仓市融合”为指导，在全国范围内设立交收仓库，提供符合区域特点的个性化、定制化的交易、物流、金融、信息服务。优化交收库运力配置，提供出入库资源的运力保障。这不仅是交易中心面向全国、前移功能、延伸服务的具体举措，更是“晋煤崛起”战略布局从省内到省外、从主产地到消费地、从沿海港口到内陆腹地的全面发力。&lt;/p&gt;&lt;p&gt;（责编：闻欣）&lt;/p&gt;&lt;h3&gt;相关阅读&lt;/h3&gt;&lt;ul&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644296.htm&quot; target=&quot;_blank&quot;&gt;打好农村贫困劳动力转移就业脱贫攻坚战&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644303.htm&quot; target=&quot;_blank&quot;&gt;加速汛期雨水排出 太原13个池渠将清淤&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644285.htm&quot; target=&quot;_blank&quot;&gt;义井片区和平南路37栋“老房子”旧貌换新颜&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644283.htm&quot; target=&quot;_blank&quot;&gt;本月起建设用地不再重复4类审查&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;ul&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644298.htm&quot; target=&quot;_blank&quot;&gt;2020年，山西要变身新型材料制造大省&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644293.htm&quot; target=&quot;_blank&quot;&gt;我省4月降水偏多 利于改善土壤墒情&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644291.htm&quot; target=&quot;_blank&quot;&gt;山西清理规范一批行政事业性收费&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/07/content_1644289.htm&quot; target=&quot;_blank&quot;&gt;山西在全国加快布点“山西煤仓”&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/06/content_1644061.htm&quot; target=&quot;_blank&quot;&gt;准朔铁路预计年底全线开通&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://localhost/news_center/content/2017-04/06/content_1644059.htm&quot; target=&quot;_blank&quot;&gt;晋蒙黄河大桥T梁顺利完成浇筑&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;<img width="580px" src="https://timgsa.baidu.com/timg?image&amp;quality=80&amp;size=b9999_10000&amp;sec=1487908995&amp;di=57f5ca26176d9bd4f7811513dfb9b9a2&amp;imgtype=jpg&amp;er=1&amp;src=http%3A%2F%2Fa.hiphotos.baidu.com%2Fzhidao%2Fpic%2Fitem%2F91ef76c6a7efce1b4d934ac5a951f3deb48f6501.jpg">', 1, 0, 0, 11);

-- --------------------------------------------------------

--
-- 表的结构 `find_auth_group`
--

CREATE TABLE IF NOT EXISTS `find_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(180) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `find_auth_group`
--

INSERT INTO `find_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '管理员', 1, '111,112,125,126,127,128,129,113,120,121,122,123,124,114,115,116,117,118,130,133,168,132,134,136,137,138,135,141,163,164,165,166,167,172,173,174');

-- --------------------------------------------------------

--
-- 表的结构 `find_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `find_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `find_auth_group_access`
--

INSERT INTO `find_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `find_auth_rule`
--

CREATE TABLE IF NOT EXISTS `find_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` char(80) DEFAULT NULL,
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `icon` varchar(60) NOT NULL,
  `orderby` int(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限规则表' AUTO_INCREMENT=175 ;

--
-- 转存表中的数据 `find_auth_rule`
--

INSERT INTO `find_auth_rule` (`id`, `pid`, `name`, `title`, `type`, `status`, `condition`, `icon`, `orderby`) VALUES
(111, 0, '', '用户', 1, 1, '', 'glyphicon-user', 2),
(112, 111, 'Admin/User/User', '用户管理', 1, 1, '', '', 1),
(113, 111, 'Admin/User/Group', '用户组管理', 1, 1, '', '', 1),
(114, 111, 'Admin/User/Rule', '节点管理', 1, 1, '', '', 1),
(115, 114, 'Admin/User/AddRule', '新增节点', 1, 1, '', '', 1),
(116, 114, 'Admin/User/RemoveRule', '删除节点', 1, 1, '', '', 1),
(117, 114, 'Admin/User/EditRule', '编辑节点', 1, 1, '', '', 1),
(118, 114, 'Admin/User/EditStatusRule', '禁用/启用 节点', 1, 1, '', '', 3),
(120, 113, 'Admin/User/AddGroup', '新增用户组', 1, 1, '', '', 1),
(121, 113, 'Admin/User/EditGroup', '编辑用户组', 1, 1, '', '', 1),
(122, 113, 'Admin/User/EditIngGroup', '封禁/启 用用户组', 1, 1, '', '', 1),
(123, 113, 'Admin/User/RemoveGroup', '删除用户组', 1, 1, '', '', 1),
(124, 113, 'Admin/User/AllotRule', '分配权限', 1, 1, '', '', 1),
(125, 112, 'Admin/User/AddUser', '新增用戶', 1, 1, '', '', 1),
(126, 112, 'Admin/User/EditUser', '编辑用户', 1, 1, '', '', 1),
(127, 112, 'Admin/User/AddUserGroup', '添加用户组', 1, 1, '', '', 1),
(128, 112, 'Admin/User/RemoveUserGroup', '删除用户组', 1, 1, '', '', 1),
(129, 112, 'Admin/User/Handle', '删除/启用/禁用/', 1, 1, '', '', 1),
(130, 0, '', '系统设置', 1, 1, '', 'glyphicon-cog', 3),
(134, 132, 'Admin/Plugin/Plugin', '插件管理', 1, 1, '', '', 1),
(132, 0, '', '插件', 1, 1, '', 'glyphicon-wrench', 2),
(133, 130, 'Admin/System/Index', '仪表盘', 1, 1, '', 'glyphicon-dashboard', 1),
(135, 132, 'Admin/Plugin/Hook', '钩子管理', 1, 1, '', '', 1),
(136, 134, 'Admin/Plugin/RemovePlugin', '删除插件', 1, 1, '', '', 1),
(137, 134, 'Admin/Plugin/SetStatus', '禁用/启用插件', 1, 1, '', '', 1),
(138, 134, 'Admin/Plugin/Install', '安装插件', 1, 1, '', '', 1),
(172, 167, 'Admin/Article/AddArticle', '发布文章', 1, 1, '', '', 0),
(173, 167, 'Admin/Article/EditArticle', '编辑文章', 1, 1, '', '', 0),
(141, 0, '', '插件后台', 1, 1, '', 'glyphicon-inbox', 1),
(163, 141, 'Admin/Admin/Index/Plugin/Validate', 'validate', 1, 1, '', '', 1),
(164, 0, '', '分类', 1, 1, '', 'glyphicon-align-justify', 1),
(165, 164, 'Admin/Type/Type', '分类管理', 1, 1, 'glyphicon-folder-open', '', 2),
(166, 0, '', '文章', 1, 1, '', 'glyphicon-picture', 1),
(167, 166, 'Admin/Article/Article', '文章管理', 1, 1, '', '', 1),
(168, 130, 'Admin/System/Site', '站点设置', 1, 1, '', '', 1),
(174, 167, 'Admin/Article/RemoveArticle', '删除文章', 1, 1, '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `find_config`
--

CREATE TABLE IF NOT EXISTS `find_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `config` varchar(600) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `find_config`
--

INSERT INTO `find_config` (`id`, `name`, `config`) VALUES
(1, 'Site', '{"title":"1312","key_word":"1","description":"1","bottom_info":"1","access":1,"count_code":"1111"}');

-- --------------------------------------------------------

--
-- 表的结构 `find_hook`
--

CREATE TABLE IF NOT EXISTS `find_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `plugin` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `find_hook`
--

INSERT INTO `find_hook` (`id`, `name`, `plugin`, `description`, `type`) VALUES
(1, 'Base', '', '位于view视图public目录下的base.html文件', 1),
(5, 'Toolbar', '', '位于view视图public目录下的base.html文件', 1),
(6, 'Validate', 'Validate', '位于view视图Login目录下的Login.html文件', 2),
(7, 'Login', 'Validate', '位于Admin/Controller/LoginController/Login方法', 1);

-- --------------------------------------------------------

--
-- 表的结构 `find_nav`
--

CREATE TABLE IF NOT EXISTS `find_nav` (
  `nid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `orderby` int(11) DEFAULT '1',
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `find_nav`
--

INSERT INTO `find_nav` (`nid`, `title`, `link`, `pid`, `type`, `orderby`) VALUES
(1, '首页', 'Home/Index/index', 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `find_plugin`
--

CREATE TABLE IF NOT EXISTS `find_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(60) CHARACTER SET utf8 NOT NULL,
  `status` int(1) unsigned NOT NULL DEFAULT '1',
  `admin` int(1) unsigned NOT NULL DEFAULT '0',
  `access` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `find_plugin`
--

INSERT INTO `find_plugin` (`id`, `sign`, `status`, `admin`, `access`) VALUES
(1, 'Validate', 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `find_plugin_config`
--

CREATE TABLE IF NOT EXISTS `find_plugin_config` (
  `id` int(10) unsigned NOT NULL,
  `sign` varchar(60) CHARACTER SET utf8 NOT NULL,
  `config` varchar(1024) CHARACTER SET utf8 NOT NULL COMMENT '插件配置json格式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `find_plugin_config`
--

INSERT INTO `find_plugin_config` (`id`, `sign`, `config`) VALUES
(0, 'Validate', '{"id":"9cfcbd31f9fc1f290114ec8f89c3b15c","key":"f116ff6db82bc24e5fd866cd0b70a47e"}');

-- --------------------------------------------------------

--
-- 表的结构 `find_type`
--

CREATE TABLE IF NOT EXISTS `find_type` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(20) CHARACTER SET utf8 NOT NULL,
  `orderby` int(10) unsigned NOT NULL DEFAULT '1',
  `status` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `find_type`
--

INSERT INTO `find_type` (`tid`, `pid`, `title`, `orderby`, `status`) VALUES
(1, 0, '随笔', 31, 1);

-- --------------------------------------------------------

--
-- 表的结构 `find_user`
--

CREATE TABLE IF NOT EXISTS `find_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 NOT NULL,
  `regdate` int(12) NOT NULL,
  `ip` varchar(16) CHARACTER SET utf8 NOT NULL,
  `lastdate` int(12) unsigned NOT NULL,
  `status` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `find_user`
--

INSERT INTO `find_user` (`uid`, `username`, `password`, `regdate`, `ip`, `lastdate`, `status`) VALUES
(1, 'admin', 'cf47fc61ddba8d840fb432632ffe8ed9fac5d662', 1489492607, '127.0.0.1', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
