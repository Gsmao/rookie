<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/CronRegister.php';


//没时间搭框架，要写测试代码跑命令行
//命令行演示：php public/index.php cron/gsmao/test a/test b/test2
//命令行解析：
//参数1：php public/index.php   这个是调用主文件
//参数2：cron/gsmao/test 这个是我随便规定的路径含义为 调用 apps/controllers/cron/gsmao.controller.php 文件里面的 testAction
//注意 ：只需要写文件前缀就行 .controller.php忽略。 方法后面必须跟上Action 不然找不到
//参数3：a/test b/test2  这个主要是把  _SERVICE['argv'] 后面的这部分参数拼接到 $_REQUEST 里面
$cronRegister = new Cron_Register();
$cronRegister->run();

//问：常见的状态码有哪些
//2xx（成功）
//200（get post请求返回成功）
//201 (post put创建资源)
//202 异步状态码，请求完成，但未处理完成
//204 处理成功，未返回内容
//
//3xx （重定向）
//301 (永久移动) 资源永久转移，客户端应使用新的url
//302 资源临时转移
//305（使用代理） 请求者只能使用代理访问请求的网页。 如果服务器返回此响应，还表示请求者应使用代理。
//
//4xx(请求错误)
//400 语法错误，服务器无法解析请求
//401 （未授权）身份校验失败
//403 （禁止）服务器解析请求成功， 但是被拒绝访问资源
//404 （未找到）未找到资源 not found 访问的资源不存在
//406 （不接受） 服务器无法根据参数特性完成请求内容（一般比如请求带上token，token已过期）
//
//5xx(服务器错误)
//500 服务器内部错误，一般是后端代码报错导致无法完成请求（有时候后端代码报错会返回404  是因为nginx重定向某个资源，然后资源被移动或删除，找不到重定向资源就会报404，我遇到过这种情况）
//502 网关错误。服务器接收到了无效的请求。比如说浏览器使用了代理等
//504 网关超时，一般最多的就是后端请求延迟。网关没有及时接收到返回信息
//
//
//1：get和post都是http协议
//2: get一般用于读取一个静态资源。比如Get到一个html文件。反复读取不应该对访问的数据有副作用，不会对数据产生影响。
//   post参数用于做一些不幂等的请求比如下单，或者是有隐私信息如帐号密码登陆这种。
//3：浏览器的POST请求都来自表单提交。每次提交，表单的数据被浏览器用编码到HTTP请求的body里。浏览器发出的POST请求的body主要有有两种格式。
//一种是application/x-www-form-urlencoded用来传输简单的数据，大概就是"key1=value1&key2=value2"这样的格式。
//另外一种是传文件，采用后者是因为application/x-www-form-urlencoded的编码方式对于文件这种二进制的数据非常低效。所以这种采用multipart/form-data格式。
//4：浏览器的Ajax api、其他app的http client，或者postman工具等接口层面，可以用以前后端交互、做微服务，HTTP协议在微服务中的使用是相当普遍的。他比较简单，易调试。
//5：从协议本身看，并没有什么限制说GET请求参数没有body,post不能把参数拼接到url后面去。然后就有了接口风格规范。post请求体使用json格式。解析格式也得到了统一。
//
//
//
//
//
//
//mysql执行replace语句时， 如果旧行和新行(要插入的数据)主键或者唯一健冲突的话，replace语句相当于2条sql：
//1. delete ;
//2. insert新数据;
//REPLACE works完全类似于insert，不同的是，如果表中的旧行与主键或UNIQUEindex的新行具有相同的值，则在插入新行之前删除旧行。
//
//所以发生死锁的原因就明朗了，并发执行该replace语句的时候会发生死锁，死锁的原因是唯一建冲突了。
//那么解决的方法就是用insert ... on duplicate key update...语句来替换replace语句，问题的到解决。
//
//但是insert ... on duplicate key update语句的性能比replace稍微差一点，而且insert ... on duplicate key update也踩过坑，
//
//
//
//
//1:先介绍了自己平台，然后让我做个自我介绍，问英语水平（四级没过，问我怎么读英文文档）
//2:cookie 和 session 区别
//3:php引入文件方式和区别
//
//1.include
//包含并运行指定文件。
//1：先按参数给出的路径寻找
//2：如果没有给出目录（只有文件名）时则按照 include_path 指定的目录寻找。
//3：如果在 include_path 下没找到该文件则 include 最后才在调用脚本文件所在的目录和当前工作目录下寻找。
//4：如果最后仍未找到文件则 include 结构会发出一条警告这一点和require不同，后者会发出一个致命错误
//5：如果定义了路径——不管是绝对路径，还是当前目录的相对路径（以 . 或者 .. 开头）——include_path都会被完全忽略。
//
//2.include_once
//在脚本执行期间包含并运行指定文件，唯一区别是如果该文件中已经被包含过，则不会再次包含。如同此语句名字暗示的那样，只会包含一次。
//
//3.require
//require 在出错时产生 E_COMPILE_ERROR 级别的错误。换句话说将导致脚本中止而 include只产生警告（E_WARNING），脚本会继续运行。
//
//4.require_once
//require_once 语句和 require 语句完全相同，唯一区别是 PHP 会检查该文件是否已经被包含过，如果是则不会再次包含。
//
//除了比较老的代码逻辑，这种都比较少用了，现在框架一般都是用命名空间，这种方式已经基本没人用了。
//一般框架框架中定义的———autoload自动加载函数，框架会对名称进行处理，分析出类库名称所对应的文件路径，然后进行文件的加载。这里需要注意的是，不同的框架在解析类库名称，分析文件路径的方式是各不一致的，毕竟各自的目录结构是不一样的。
//
//
//4:字符串操作函数说5个，他的功能是啥
//strtotime();strlen();substr();strpos();explode();implode();
//
//6:get 和 post 区别
//7:项目。主要是项目问了40分钟，你遇到的困难？你的成绩，你做了些什么？还会问你做了哪些让你觉得比较有成就的，然后说一下，再问你做了多久之类。
//8:php框架了解哪些，有没有自己私下学习过？
//9:聊一下redis，没问啥问题，就让你说，我回答的比较烂（当时有点懵了已经）
//10:聊到了转语言，问当时转php花了多久。
//11:项目上面就跟你瞎聊，主要就是问你，你都做了啥，想看你的主要工作，负责内容。有没有做什么有质量的东西出来，怎么做的？花了多久？
//12:嗯，有没有什么想问我的？回去等通知吧