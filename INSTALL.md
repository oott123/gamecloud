#安装GameCloud

## 准备工作

1. 从GitHub下载GameCloud最新的[ZIP压缩包](https://github.com/oott123/gamecloud/archive/master.zip)。
2. 解压，将多余目录去除。
3. 创建一个（或者使用一个现有的）MySQL数据库，记录下数据库服务器、数据库名、用户名和密码。

## 安装文件

只需简单的将文件夹下所有内容上传到你的网络服务器即可。（db.sql、http\_dll.e和http\_dll.dll可以不上传）

## 安装数据

1. 登录PhpMyAdmin。（没有PMA？试试[Adminer](http://www.adminer.org/)）  
2. *可选* 用记事本打开根目录下的db.sql文件，将所有的`pre_`替换为你想要的前缀（例如`gamecloud_`）并保存。
3. *建议* 用记事本打开根目录下的db.sql文件，将`admin`替换为你想要的用户名（例如`oott123`）并保存。
3. 选择你的数据库，将准备好的db.sql文件导入到数据库。（PMA：导航栏——导入；Adminer：左上角——SQL命令）  
4. 打开http://*your_url_for_gamecloud*/index.php/modify/login/，使用你的用户名（默认是`admin`）和密码`demo`登录。修改你的密码。  
5. Have Fun!