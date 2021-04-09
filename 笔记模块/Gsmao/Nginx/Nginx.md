### Nginx
1. Nginx和apache区别
2. Nginx的异步非阻塞, I/O多路复用？
3. Nginx的内存分配

###Nginx如何处理请求？
step1：用户将http请求发送给nginx服务器(用户和nginx服务器进行三次握手进行TCP连接)
step2：nginx会根据用户访问的URI和后缀对请求进行判断
step3：
动态内容，nginx将请求交给fastcgi客户端，通过fastcgi_pass将用户的请求发送给php-fpm
静态资源，nginx将用户请求的静态资源返回给用户。
step4： php-fpm会调度管理进程去调用php动态程序解析服务器
step5：php会将查询到的结果返回给nginx
step6：nginx构造一个响应报文将结果返回给用户


###Nginx与PHP的两种通信方式
1:unix socket和tcp socket
unix socket 没有tcp开销，而tcp需要经过loopback，还要申请临时端口和tcp相关资源。  
unix socket高并发时候不稳定，连接数爆发时，会产生大量的长时缓存，大数据包可能会直接出错不返回异常。tcp这样的面向连接的协议，多少可以保证通信的正确性和完整性。  
