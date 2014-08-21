##Cloud Paper
---
> [CloudPaper云纸片](http://blank.jingwentian.com/) - 用于临时记录文字的云端空白纸片

日常生活中经常需要记录一些琐碎的、临时的、想传递给他人的文字片段。这些文字不成文没必要写成博客，或者这些文字你不想让别人看到，无论如何，随笔记下想记录的每一些事。

- 支持markdown
- 生成唯一链接(可修改)
- 文字加密
- 支持上传图片
- 支持挂件

**数据库表结构：**

      CREATE TABLE IF NOT EXISTS `blank` (
      `id` int(10) NOT NULL COMMENT '笔记自增ID',
        `userid` int(10) NOT NULL COMMENT '关联用户id',
        `content` text NOT NULL COMMENT '笔记内容',
        `sharelink` char(32) NOT NULL COMMENT '分享url',
        `password` varchar(50) NOT NULL COMMENT '笔记加密',
        `time` datetime NOT NULL COMMENT '笔记时间'
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='笔记表' AUTO_INCREMENT=1 ;
      
      ALTER TABLE `blank` ADD PRIMARY KEY (`id`), ADD KEY `sharelink` (`sharelink`);
  
**Nginx rewrite**

  rewrite ^/share/(.*)$ /index.php?id=$1 last;
  rewrite ^/widget/(.*)$ /widget.php?id=$1 last;
  
最后感谢用到的所有开源代码或服务：bootstrap、medoo、michelf-markdown、upyun等。

  
