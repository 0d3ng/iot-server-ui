<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-10-06 23:29:18 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:29:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:29:18 --> id= ci78
DEBUG - 2024-10-06 23:29:18 --> Total execution time: 0.1438
DEBUG - 2024-10-06 23:33:50 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:33:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:33:50 --> id= ci78
DEBUG - 2024-10-06 23:33:50 --> result: {"status": true, "message": "Success", "data": {"group_code_name": "other", "key_access": "3t5ce2283z51hz74", "device_code": "ci78", "name": "Node 123", "field": ["temperature", "humidity", "id"], "date_add": {"$date": 1728105959300}, "add_by": "6365a05577697514da9550e2", "active": true, "information": {"location": "Fukui dormitory", "detail": "fufufafa", "purpose": "try testing"}, "communication": {"http-post": false, "mqtt": true, "server": "localhost", "port": "1883", "topic": "sensor/node-red1"}, "updated_by": "6365a05577697514da9550e2", "id": "6700cde75c89832d026096c0"}}
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'data' of non-object C:\xampp\htdocs\iot-server-ui\application\controllers\Device.php 315
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'group_code_name' of non-object C:\xampp\htdocs\iot-server-ui\application\controllers\Device.php 316
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'field' of non-object C:\xampp\htdocs\iot-server-ui\application\controllers\Device.php 321
ERROR - 2024-10-06 23:33:50 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\iot-server-ui\application\controllers\Device.php 377
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'device_code' of non-object C:\xampp\htdocs\iot-server-ui\application\controllers\Device.php 338
ERROR - 2024-10-06 23:33:50 --> Severity: Warning --> file_get_contents(http://localhost:3001/device/data//): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 C:\xampp\htdocs\iot-server-ui\application\core\MY_Model.php 30
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'status' of non-object C:\xampp\htdocs\iot-server-ui\application\models\Device_m.php 55
ERROR - 2024-10-06 23:33:50 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\iot-server-ui\application\models\Device_m.php 56
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'name' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 21
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'device_code' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 23
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'information' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 27
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'location' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 27
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'information' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 29
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'purpose' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 29
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'information' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 35
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'detail' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 35
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'field' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 123
ERROR - 2024-10-06 23:33:50 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 123
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'device_code' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 288
ERROR - 2024-10-06 23:33:50 --> Severity: Notice --> Trying to get property 'device_code' of non-object C:\xampp\htdocs\iot-server-ui\application\views\device_data_v.php 335
DEBUG - 2024-10-06 23:33:50 --> Total execution time: 0.1987
DEBUG - 2024-10-06 23:37:36 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:37:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:37:36 --> id= ci78
DEBUG - 2024-10-06 23:37:36 --> result: {"status": true, "message": "Success", "data": {"group_code_name": "other", "key_access": "3t5ce2283z51hz74", "device_code": "ci78", "name": "Node 123", "field": ["temperature", "humidity", "id"], "date_add": {"$date": 1728105959300}, "add_by": "6365a05577697514da9550e2", "active": true, "information": {"location": "Fukui dormitory", "detail": "fufufafa", "purpose": "try testing"}, "communication": {"http-post": false, "mqtt": true, "server": "localhost", "port": "1883", "topic": "sensor/node-red1"}, "updated_by": "6365a05577697514da9550e2", "id": "6700cde75c89832d026096c0"}}
DEBUG - 2024-10-06 23:37:36 --> Total execution time: 0.0988
DEBUG - 2024-10-06 23:47:50 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:47:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:47:50 --> id= ci78
DEBUG - 2024-10-06 23:47:50 --> result: {"status": true, "message": "Success", "data": {"group_code_name": "other", "key_access": "3t5ce2283z51hz74", "device_code": "ci78", "name": "Node 123", "field": ["temperature", "humidity", "id"], "date_add": {"$date": 1728105959300}, "add_by": "6365a05577697514da9550e2", "active": true, "information": {"location": "Fukui dormitory", "detail": "fufufafa", "purpose": "try testing"}, "communication": {"http-post": false, "mqtt": true, "server": "localhost", "port": "1883", "topic": "sensor/node-red1"}, "updated_by": "6365a05577697514da9550e2", "id": "6700cde75c89832d026096c0"}}
DEBUG - 2024-10-06 23:47:50 --> result groupsensor_m= {"status": false, "message": "Data Not Found", "data": {"code_name": "other"}}
DEBUG - 2024-10-06 23:47:50 --> Total execution time: 0.1085
DEBUG - 2024-10-06 23:51:58 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:51:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:51:58 --> id= ci78
DEBUG - 2024-10-06 23:51:58 --> result: {"status": true, "message": "Success", "data": {"group_code_name": "other", "key_access": "3t5ce2283z51hz74", "device_code": "ci78", "name": "Node 123", "field": ["temperature", "humidity", "id"], "date_add": {"$date": 1728105959300}, "add_by": "6365a05577697514da9550e2", "active": true, "information": {"location": "Fukui dormitory", "detail": "fufufafa", "purpose": "try testing"}, "communication": {"http-post": false, "mqtt": true, "server": "localhost", "port": "1883", "topic": "sensor/node-red1"}, "updated_by": "6365a05577697514da9550e2", "id": "6700cde75c89832d026096c0"}}
DEBUG - 2024-10-06 23:51:58 --> result groupsensor_m= {"status": false, "message": "Data Not Found", "data": {"code_name": "other"}}
DEBUG - 2024-10-06 23:51:58 --> Total execution time: 0.1169
DEBUG - 2024-10-06 23:56:24 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:56:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:56:24 --> Total execution time: 0.1684
DEBUG - 2024-10-06 23:59:15 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:15 --> Total execution time: 0.0676
DEBUG - 2024-10-06 23:59:17 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:17 --> Total execution time: 0.0582
DEBUG - 2024-10-06 23:59:18 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:18 --> Total execution time: 0.0812
DEBUG - 2024-10-06 23:59:23 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:23 --> Total execution time: 0.1482
DEBUG - 2024-10-06 23:59:33 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:33 --> Total execution time: 0.0738
DEBUG - 2024-10-06 23:59:35 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:35 --> Total execution time: 0.0484
DEBUG - 2024-10-06 23:59:36 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:36 --> Total execution time: 0.1169
DEBUG - 2024-10-06 23:59:40 --> UTF-8 Support Disabled
DEBUG - 2024-10-06 23:59:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-06 23:59:40 --> Total execution time: 0.0677
