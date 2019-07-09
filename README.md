# FaShop
长期维护版本，欢迎大家参与；

## 注意：v3版本还有大量代码未提交，仅供学习
> 后续会补进来，最近有些忙

## 安装
```bash
# 安装swoole
docker-compose up --d swoole

# 进入docke容器内部执行命令
docker-compose exec swoole bash

composer install

php easyswoole start
```
## 访问
http://127.0.0.1:9511
> 如果想修改端口号请配置dev.php 和 docker-compose.yml

## 参与开发
更多项目请关注：[https://www.fashop.cn](https://www.fashop.cn)

期待您的加入~ ,欢迎大家踊跃提交代码。

开发问题欢迎一起交流 ： QQ交流群：632466687

小程序项目地址：[https://github.com/mojisrc/wechat-mini-shop](https://github.com/mojisrc/wechat-mini-shop)

后台前端项目地址：[https://github.com/mojisrc/fashop-admin](https://github.com/mojisrc/fashop-admin)

App项目地址：[https://github.com/mojisrc/fashop-client-react-native](https://github.com/mojisrc/fashop-client-react-native)


## 文档地址
[https://www.fashop.cn](https://www.fashop.cn)
## 最新功能

- 自定义后台拖拽界页面；
- 默认3种商品分类页面；
- 订单管理；
- 退款退货管理；
- 收藏列表；
- 地址管理，1.用户添加，2.调用微信地址管理接口；
- 购物车管理，支持切换规格；
- 商品管理，支持多规格切换

## 即将推出功能
- 拼团
- 自定义个人中心
- 还有....如果您有什么需求，可以进群提出，说不定我们会优先处理， QQ交流群：632466687



```bash
# 每次做项目只需要执行一次，安装swoole环境
docker-compose up swoole
# 开启
docker-compose start swoole
# 进入swoolel的docker内部可以执行命令行
docker-compose exec swoole bash

# php依赖安装
composer install
# 第一次执行的话需要
php vendor/bin/easyswoole install
# 以后每次调试运行是
php easyswoole start

```
虽然配置里的端口是9510，但那是docker内部的，映射出来是9511（可随意改）,docker-compose.yml定义了
```bash
swoole:
    image: ezkuangren/swoole4
    ports:
      - "9511:9510"
    volumes:
      - ./:/var/www/project
    stdin_open: true
    tty: true
    privileged: true
```
那么访问的端口号就是127.0.0.1:9511



## 后台界面
<p>
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvews9zi8kj31kw0ttgtr.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewtsm9ypj31kw0tytw0.jpg" width="260px">
<img src="https://ws2.sinaimg.cn/large/006tNbRwgy1fvewu4rq6tj31kw0tdwzv.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewufq30xj31kw0ts14y.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvewurjn9sj31kw0u04ja.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvewv4n551j31kw0tztox.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fveww6rgx6j31kw0tpjzo.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewwt3plmj31kw0tuqb2.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewx6cpo6j31kw0qggvw.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvewxsjd77j31kw0tmwm8.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvewy3vnyqj31kw0tqwmy.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewyeg8i5j31kw0tk12j.jpg" width="260px">
<img src="https://ws3.sinaimg.cn/large/006tNbRwgy1fvewz0i0hzj31kw0tzwpw.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvex0fii54j31kw0tuk18.jpg" width="260px">
<img src="https://ws1.sinaimg.cn/large/006tNbRwgy1fvex06u7waj31kw0tln4x.jpg" width="260px">
<img src="https://ws1.sinaimg.cn/large/006tNbRwgy1fvex0xgx3dj31kw0se44y.jpg" width="260px">
<img src="https://ws4.sinaimg.cn/large/006tNbRwgy1fvex15ecmdj31kw0tbdmd.jpg" width="260px">
</p>
