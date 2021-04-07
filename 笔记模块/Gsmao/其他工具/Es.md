可以将 ES 中的这三个概念和 MySQL 类比：  

+ Index 对应 MySQL 中的 Database；  
+ Type 对应 MySQL 中的 Table；  
+ Document 对应 MySQL 中表的记录。  

一个MySQL实例中可以创建多个 Database，一个Database中可以创建多个Table。  

从 ES 7.0 开始，Type 被废弃  
在 7.0 以及之后的版本中 Type 被废弃了。一个 index 中只有一个默认的 type，即 _doc，也可以这样理解：
+ ES 实例：对应 MySQL 实例中的一个 Database。  
+ Index 对应 MySQL 中的 Table 。  
+ Document 对应 MySQL 中表的记录。  



