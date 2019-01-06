# fashop docker版本使用说明
## Docker 环境准备
安装 Docker 环境及加速: [阿里云 - 镜像加速器](https://cr.console.aliyun.com/#/accelerator)

docker 及 docker-compose 基础知识:

* [Docker官方文档](href="https://docs.docker.com/)
* [composer 入门指南](http://docs.phpcomposer.com/00-intro.html)
 
## fashop 源码准备
[详见文档](https://www.fashop.cn/guide/)
## 拉取镜像

```shell
docker pull fashop/fashop:v1.0.0
```
## 获取容器内代码
* 官方镜像已经满足开发需求, 直接使用官方镜像是个不错的选择

```shell
docker run -d -p 9510:9510 --name fashop fashop/fashop:v1.0.0
```
`上面代码存放在容器内部，如何才能将修改同步到容器内部代码了`

* 创建数据卷

```shell
docker volume create fashopv1
```
* 挂载数据卷到容器

```shell
docker run -d -p 9510:9510 -v fashopv1:/var/www/fashop --name fashop fashop/fashop:v1.0.0
```
* 删除上一步创建的容器，查看本地挂载的目录

```shell
docker inspect fashopv1
```
假设挂载的目录为/var/www/fashop_temp,进入这个目录，你将看到fashop的源码，将该目录代码移动到你宿主机指定的位置，我移动到了/var/www/fashop_local
## 启动容器

在/var/www/fashop_local里，你讲看到Dockerfile和docker-compose.yml

* Dockerfile（运行下面命令，生成自己的镜像，可用于生产环境）

```shell
docker build -t yourname/myfashop .
```
* docker-compose.yml（启动容器，挂载本地代码到容器内部）

```shell
version: '3'

services:
    fashop:
       image: fashop/fashop:v1.0.0 (镜像版本根据实际情况修改)
#       build: ./
       ports:
         - "9510:9510"
       volumes:
         - ./:/var/www/fashop
       stdin_open: true
       tty: true
       privileged: true
       entrypoint: ["php", "/var/www/fashop/fashop", "start"]

```
* 执行docker-compose up -d (-d是运行在后台)

`nginx配置修改：`root 目录指到本地源码所在目录哦！

**到此为止，宿主机和docker容器内部代码就可以同步了！尽情的体验fahsop吧！**


