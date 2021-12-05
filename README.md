# アプリ名

ママさんタクシー

## アプリの概要

チャイルドシート付きタクシー予約アプリ。  
保育園に通園する子どもを持つ保護者が、  
日時・経由地を設定し、タクシー送迎を予約できる。

## DB関連スクリプト

### データベース作成

```sql

--データベース作成

CREATE DATABASE mama_taxi;

--ユーザー作成

CREATE USER mama_user IDENTIFIED BY '1234';
GRANT ALL ON mama_taxi.* to mama_user;

```

### テーブル作成(計12個)

1. users
1. areas
1. adresses
1. children
1. reserves
1. reserve_children
1. drivers
1. shifts
1. schedules
1. thoughts
1. categorys
1. news

```sql

--ユーザー情報

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE KEY NOT NULL,
    password VARCHAR(255) NOT NULL,
    sex TINYINT NOT NULL,
    birth DATE NOT NULL,
    tel VARCHAR(11) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

```
```sql

--地域情報

CREATE TABLE areas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    area_code INT NOT NULL,
    x_axis INT NOT NULL,
    y_axis INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

```
```sql

--住所情報

CREATE TABLE adresses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    tel VARCHAR(11),
    postal_code CHAR(8) NOT NULL,
    adress VARCHAR(255) NOT NULL,
    area_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (area_id) REFERENCES areas (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--子ども情報

CREATE TABLE children (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    sex TINYINT NOT NULL,
    birth DATE NOT NULL,
    adress_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (adress_id) REFERENCES adresses (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--予約情報

CREATE TABLE reserves (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    departure_time DATETIME NOT NULL,
    destination_time DATETIME NOT NULL,
    departure_area_id INT NOT NULL,
    departure_postal_code CHAR(8) NOT NULL,
    departure_adress VARCHAR(255) NOT NULL,
    destination_area_id INT NOT NULL,
    destination_postal_code CHAR(8) NOT NULL,
    destination_adress VARCHAR(255) NOT NULL,
    waypoint_1_area_id INT,
    waypoint_1_postal_code CHAR(8),
    waypoint_1_adress VARCHAR(255),
    waypoint_2_area_id INT,
    waypoint_2_postal_code CHAR(8),
    waypoint_2_adress VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (departure_area_id) REFERENCES areas (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (destination_area_id) REFERENCES areas (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (waypoint_1_area_id) REFERENCES areas (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (waypoint_2_area_id) REFERENCES areas (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--予約-子ども情報

CREATE TABLE reserve_children (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reserve_id INT NOT NULL,
    child_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (reserve_id) REFERENCES reserves (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (child_id) REFERENCES children (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--運転手情報

CREATE TABLE drivers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    birth DATE NOT NULL,
    sex TINYINT NOT NULL,
    hire_date DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

```
```sql

--勤務シフト情報

CREATE TABLE shifts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    driver_id INT NOT NULL,
    commuting_time DATETIME NOT NULL,
    leave_time DATETIME NOT NULL,
    rest_time INT NOT NULL,
    rest_timing DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES drivers (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--スケジュール情報

CREATE TABLE schedules(
    id INT PRIMARY KEY AUTO_INCREMENT,
    driver_id INT NOT NULL,
    reserve_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES drivers (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (reserve_id) REFERENCES reserves (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--感想情報

CREATE TABLE thoughts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    reserve_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    goods INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (reserve_id) REFERENCES reserves (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```
```sql

--カテゴリ情報

CREATE TABLE categorys(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

```
```sql

--ニュース情報

CREATE TABLE news(
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categorys (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

```

```sql

--登録情報

INSERT INTO
    categorys
    (name, created_at)
    VALUE
    ('重要'),
    ('キャンペーン'),
    ('募集'),
    ('PR');

--地域設定

INSERT INTO
    areas
    (name, area_code, x_axis, y_axis)
    VALUE
    ('中央区', '0', '0', '0'),
    ('北区', '1', '1', '3'),
    ('東区', '2', '4', '-1'),
    ('南区', '3', '-1', '-3'),
    ('西区', '4', '-2', '0');

INSERT INTO
	users
	(name, email, password, sex, birth, tel)
VALUE
	('test', 'test@test', 'testtest', 1, '1980/01/01', '00000000000');

INSERT INTO
    reserves
    (user_id, departure_time, destination_time, departure_area_id, departure_postal_code, departure_adress, destination_area_id, destination_postal_code, destination_adress, waypoint_1_area_id, waypoint_1_postal_code, waypoint_1_adress, waypoint_2_area_id, waypoint_2_postal_code, waypoint_2_adress)
VALUE
    (1, '1980/01/01/00:00', '1980/01/01/00:00', 1, '000-0000', 'test', 1, '000-0000', 'test', 1, '000-0000', 'test', 1, '000-0000', 'test'),
    (1, '2100/01/01/00:00', '2100/01/01/00:00', 1, '000-0000', 'test', 1, '000-0000', 'test', 1, '000-0000', 'test', 1, '000-0000', 'test');

```