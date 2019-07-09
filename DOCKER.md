## 使用说明
根目录执行
```bash
docker-compose up --d swoole
docker-compose exec swoole bash
```
其他，进入到容器后
```bash
# 如果需要github的token，输入即可，用了一些未开发完的库
composer install
php easyswoole start
```