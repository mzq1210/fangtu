房图系统概述\(v1.0\)

## 目录介绍

```
assets/             contains assets definition
  commands/           命令行目录
  config/             项目配置
  controllers/        控制器
  models/             模型
  runtime/            缓存目录
  vendor/             框架包及第三方扩展
  views/              模板
  web/                应用入口
  data/               上传文件目录
  doc/                文档目录(md文件,如README.md)
```

## 系统要求

* php7.0及以上
* redis扩展
* mongodb扩展
* swoole扩展
* mysql

## 运行系统

```php
./yii init //修改目录权限
./yii websocket  //后台运行socket
```

## 版本说明

v1.0 bate

* 采用socket技术,实现异步标注,解决速度慢的问题
* 动态生成标注图\(支持上千种图标\)
* 支持自定义图标颜色
* 支持自定义显示名称
* 支持图层排序,设置隐藏及公开或私有\(公开图层下的数据其它成员可查看\)
* 支持地图标注区域\(可设置背景颜色及边框样式\)
* 账号统一登录



