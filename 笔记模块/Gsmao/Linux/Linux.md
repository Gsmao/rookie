### Linux基础命令篇章
文件和目录的增删改查：  
mkdir、rm、cp、mv、touch、  
find /user/tmp/ -name 'a*'  

查看日志：  
vim进去搜索指定的，或者是tail -f 动态监控。  

查询配置：  
cat查询最后一屏  

tar命令打包解包：  
打包：tar -zcvf ab.tar aa.txt bb.txt （打包并压缩/usr/tmp 下的所有文件 压缩后的压缩包指定名称为xxx.tar）  
解包：tar -zxvf  将/usr/tmp 下的ab.tar解压到当前目录下   

grep查找命令：  
1：在当前目录中，查找后缀有 file 字样的文件中包含 test 字符串的文件，并打印出该字符串的行  
grep test *file    
2：查找指定目录/etc/acpi 及其子目录（如果存在子目录的话）下所有文件中包含字符串"update"的文件，并打印出该字符串所在行的内容  
grep -r update /etc/acpi   
3：查找文件名中包含 test 的文件中不包含test 的行  
grep -v test *test*  

定时任务指令crontab  
命令：*   *    *   *   *   command  （分  时  日  月  周  命令）  

ps命令:  
查看所有正在运行的进程:ps -ef,通常是查看进程的开始时间和执行时间，查看进程是否按照预期执行  

awk 文本处理  
1：统计 /log文件中包含 X行 的总数  
awk 'BEGIN{X=0}/2021-03-29 15:00:/{X+=1}END{print "I find",X,"request"}' /log/xxx.log  
