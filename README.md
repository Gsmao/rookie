# 项目名- rookie
> 开发须知：    
> 执行命令：composer dump-autoload加载类  这个是跑测试代码用的, 仅限于PHP开发
> 听说一个私有仓库好像只能支持3名协作开发人员？  

> 清除本地缓存：(账号信息等都会清掉)
>>git rm -r --cached .
>>git add .
>>git commit -m "update .gitignore"

# 合作github身份令牌
> 这个找我要。。。不好写在readme里面

# 人员名单
> users = 1, gsmao - 毛港胜  
> users = 2, mxu - 徐明

#目录结构
- apps 
  - config 这个没用
  - http 这个我创建class用来调用的，这个目录下面放公用类
    - gsmao 这个我自己的类我放里面，后续保持一致
    - mxu 徐明
- public 
  - index.php 这个主要用来调试代码
 
- 笔记模块
    - Common 公共笔记整理文件
    - Gsmao 毛港胜目录
    - Mxu 徐明目录
    - Test 调试用的，md基本操作文档
 