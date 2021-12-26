# Fkun-Book-keeping
for students to learn how to manage money
<br>
基于https://github.com/zhengyong100/ji 开发

项目持续开发中，目前各项功能普遍适用性不高……
由于精力有限，后续开发可能不再考虑环境初始化。
如需自行搭建服务，请使用Releases中的版本，最后更新于2021年06月14日。

## 如何部署到自己的服务器
### 环境要求
- PHP 5.0（或更高）
- MySQL
> 新手推荐直接使用宝塔面板配置LNMP环境
### 需要准备的文件
Release中最新的安装包。<br>


**↓下面的部分为需要设置的部分↓**
### config.php
**头部**<br>
`db_servername`：数据库服务器地址<br>
`db_username`：数据库用户名<br>
`db_password`：数据库密码<br>
`db_dbname`：数据库名称<br>
**基本设置**<br>
`date_default_timezone_set`：默认时区<br>
可选项有
- 亚洲/上海
- America/Argentina/Buenos_Aires
- Europe/Berlin
### install.php
完成`config.php`中的设置后，在浏览器中进入`install.php`(输入`你的网址/install.php`)。<br>
等待完成初始化后即可进入登陆页面。
