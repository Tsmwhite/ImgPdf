# ImgPdf
php 生成图片pdf，避免pdf内容被复制

执行步骤
1.首先通过TCPDF生成pdf文件（可添加水印背景）
2.通过 Imagick 扩展将pdf转换为图片
3.将图片生成新的pdf


#依赖
@tecnickcom/tcpdf
composer 安装 
composer require tecnickcom/tcpdf

#PHP扩展库
@Imagick
安装步骤

根据环境下载合适的 imagick扩展 和 imagemagick程序

1.下载拓展
下载地址一: http://windows.php.net/downloads/pecl/releases/imagick/
下载地址二: https://pecl.php.net/package/imagick
要点: 注意对应php版本 ts还是nts x86还是x64
这里以phpinfo()为准



所以我应该下载imagick 3.4.3版本 PHP5.6  Non Thread Safe (NTS) x86 的拓展——php_imagick-3.4.3-5.6-nts-vc11-x86.zip

2. 安装拓展
解压上述文件后，将php_imagick.dll复制到php/ext目录，或者其他你的存放拓展的目录
修改php.ini 加上extension=php_imagick.dll，注意php可能有多个ini，以phpinfo为准
此时复制解压上述文件目录中其他dll到php目录，重启apache，此时phpinfo显示拓展安装成功，但是 ImageMagick number of supported formats为0，到这里成功安装了一半
3 下载imagemagick程序
下载地址：http://windows.php.net/downloads/pecl/deps/
imagemagick还有官网下载，此处不鼓励从imagemagick官方下载，他们的网站上我并没有找到历史版本下载，安装失败的几率很大
下载与phpinfo提示一致的版本，此时需要注意  1.软件版本对应     2.vc11还是vc14 3.x86还是x64 都要以phpinfo为准，我的

所以我下载 ImageMagick-6.9.3-7

4 安装imagemagick程序
下载的文件解压后，将程序整体复制到无空格 无中文字符的目录中 E:\Program Files (x86)\
配置环境变量，在“此电脑”右键“属性”，以此点击“高级” “环境变量” ，在 “系统变量”中找到键为path的数据，双击path，选择“新建”，将刚刚放程序的目录“E:\Program Files (x86)\ImageMagick\bin”填入即可
将“E:\Program Files (x86)\ImageMagick\bin”目录中的所有的以“.DLL‘为后缀的文件放入php的根目录，应该有145个
　

重启计算机


