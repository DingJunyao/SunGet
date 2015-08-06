#SunGet#

### 计算日出日落时间并以客户端时间显示，同时返回时间段 ###

### 作者 ###

丁俊尧

### 网站 ###

<http://www.hlworks.org/>
    
### 格式 ###

PHP（>=5）

### 输出格式 ###

JSON

### 编码 ###

UTF-8

### 文件 ###

sunget.php - 执行标题所述功能的文件

demo.html - 演示文件

README.md - 自述文档

### 参数 ###

lng - 经度

lat - 纬度

localOffset - 客户端时区，只写数字（例：UTC+8 -> 8；UTC -> 0；UTC-8 -> -8）

### 输出 ###

示例：`{"sunrise":"05:49","sunset":"19:34","period":"day","period_exact_chinese":"下午","period_exact_western":"afternoon"}`

sunrise - 日出时间，时:分，均为两位数，极昼极夜为"null"

sunset - 日落时间，时:分，均为两位数，极昼极夜为"null"

period - 粗略的时段，有两个值：day,nighttime

period_exact_chinese - 中式精确时段，有七个值：上午，中午，下午，晚上，凌晨，白天，黑夜 （后两个值仅用于极昼极夜）

period_exact_western - 西式精确时段，有七个值：morning,noon,afternoon,evening,night,day,nighttime （后两个值仅用于极昼极夜）

精确时段划分依据请见“规定”一节。

### 规定 ###

在白天(day)，从日出开始白天的5/12~7/12为中午(noon)，此时间段之前为上午(morning)，之后为下午(afternoon)；

在黑夜(nighttime)，前1/4为evening，后3/4为night；黑夜的前半部分为晚上，后半部分为凌晨。

白天、中午占有两端点值。evening、晚上占有结束端点值。

极昼视为白天(day)，极夜视为黑夜(nighttime)。

### 联系方式 ###

E-mail：admin\#\#\#hlworks.org （\#\#\# -> @）

微博：[@我就是丁俊尧](http://weibo.com/happysonlab/)

### 鸣谢 ###

danatauthenticdesign.net 提供的计算两个时区的时间差的PHP函数

<http://php.net/manual/zh/function.timezone-offset-get.php>


请在使用该脚本时署上我的名字，谢谢！

-----

#SunGet#

### Calculating the Sunrise Time and Sunset Time and Express them in Client Time with Period ###

### By ###

Ding Junyao

### Website ###

<http://www.hlworks.org/>

### Format ###

PHP (>=5)

### Output Format ###

JSON

### Encoding ###

UTF-8

### Files ###

sun.php - File which execulate the functions the title said

demo.html - Demo File

README.md - Readme File

### Parameters ###

lng - Longtitude

lat - Latitude

localOffset - The offset number of the client, only numbers(eg. UTC+8 ->8; UTC -> 0; UTC-8 -> -8). 

### Output ###

Example:`{"sunrise":"05:49","sunset":"19:34","period":"day","period_exact_chinese":"下午","period_exact_western":"afternoon"}`

sunrise - The sunrise time, HH:MM, it's "null" when polar day or polar night

sunset - The sunrise time, HH:MM, it's "null" when polar day or polar night

period - Rough period, two values:day,nighttime

period_exact_chinese - Chinese exact period, seven values:上午,中午,下午,晚上,凌晨,白天,黑夜 (the last two values are only used when polar day and polar night)

period_exact_western - Western exact period, seven values:morning,noon,afternoon,evening,night,day,nighttime (the last two values are only used when polar day and polar night)

Please read **Note** to learning the rule of dividing the time into exact periods in this script. 

### Note ###

In daytime(day，白天), from the sunrise time, the 5/12~7/12 of the daytime is noon（中午）, the period before noon is morning（早上） and the period after noon is afternoon（下午）;

In nighttime(nighttime，黑夜), the former 1/4 of it is evening and the rest is night; the former half of it is 晚上 and the rest is 凌晨. 

Day and noon have two points occupied, and evening and 晚上 have end points occupied. 

Polar day=day, polar night=nighttime. 

### Contact ###

E-mail:admin\#\#\#hlworks.org (\#\#\# -> @)

### Thanks to ###

The PHP Function which calculates the time difference between two timezones by danatauthenticdesign.net

<http://php.net/manual/zh/function.timezone-offset-get.php>


PLEASE write my name when using this script, Thanks!
