/*
 * Database structure for uska.de
 *
 * $Id$
 */

create table progress (
  bz_id                       int primary key,
  description                 varchar(255) not null
) Type=InnoDB
insert into progress values (10000, "Init")
insert into progress values (20000, "Done")
insert into progress values (20001, "Update")
insert into progress values (30000, "Locked")
insert into progress values (30001, "Delete")
insert into progress values (40000, "Deleted")

create table team (
  team_id                     int auto_increment primary key,
  name                        varchar(255) not null,
) Type=InnoDB

create table player (
  player_id                   int auto_increment primary key,
  player_type_id              int not null,
  team_id                     int not null,
  
  firstname                   varchar(50) not null,
  lastname                    varchar(50) not null,
  username                    varchar(20) null,
  
  password                    varchar(60) null,
  email                       varchar(255) null,
  
  position                    int null,
  created_by                  int null,
  
  bz_id                       int not null,
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table player add unique index (username)
alter table player add unique index (email)
alter table player add foreign key (created_by) references player(player_id)
alter table player add foreign key (team_id) references team(team_id)
alter table player add foreign key (bz_id) references progress(bz_id)

create table event_type (
  event_type_id               int primary key,
  description                 varchar(50) not null,
  feature                     int null
) Type=InnoDB
insert into event_type values (1, "Training")
insert into event_type values (2, "Turnier")
insert into event_type values (3, "Sonstiges")

create table event (
  event_id                    int auto_increment primary key,
  team_id                     int not null,
  event_type_id               int not null
  
  name                        varchar(255) not null,
  description                 varchar(1023) null,
  
  target_date                 datetime not null,
  deadline                    datetime null,
  
  max_attendees               int null,
  req_attendees               int null,
  allow_guests                int default 1,
  
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table event add index (target_date)
alter table event add foreign key (team_id) references team(team_id)
alter table event add foreign key (event_type_id) references event_type(event_type_id)

create table event_type_acl (
  player_id                   int not null,
  event_type_id               int not null,
  
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table event_type_acl add foreign key (player_id) references player(player_id)
alter table event_type_acl add foreign key (event_type_id) references event(event_type_id)

create table event_attendee (
  event_id                    int not null,
  player_id                   int not null,
  
  attend                      int not null,
  offers_seats                int not null,
  needs_driver                int not null,
  
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table event_attendee add foreign key (event_id) references event(event_id)
alter table event_attendee add foreign key (player_id) references player(player_id)
alter table event_attendee add index (event_id)
alter table event_attendee add index (player_id)
alter table event_attendee add unique index (event_id, player_id)

create table event_points (
  event_id                    int not null primary key,
  player_id                   int not null primary key,
  
  points                      int null,
  
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table event_points add foreign key (event_id) references event(event_id)
alter table event_points add foreign key (player_id) references player(player_id)
alter table event_points add index (player_id)

create table permission (
  permission_id               int auto_increment primary key,
  name                        varchar(50) not null
) Type=InnoDB
insert into permission values (1, "create_player")
insert into permission values (2, "create_event")
insert into permission values (3, "create_news")
insert into permission values (4, "edit_points")

create table plain_right_matrix (
  permission_id               int not null,
  player_id                   int not null
) Type=InnoDB
alter table plain_right_matrix add index (player_id)
alter table plain_right_matrix add unique index (permission_id, player_id)
alter table plain_right_matrix add foreign key (permission_id) references permission(permission_id)
alter table plain_right_matrix add foreign key (player_id) references player(player_id)

create table mailinglist (
  mailinglist_id              int auto_increment primary key,
  name                        varchar(255) not null,
  address                     varchar(255) not null,
  
  bz_id                       int not null default 20000,
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table mailinglist add foreign key (bz_id) references progress(bz_id)
alter table mailinglist add unique index (name)
alter table mailinglist add unique index (address)

create table mailinglist_player_matrix (
  player_id                   int not null,
  mailinglist_id              int not null,
  
  lastchange                  datetime not null,
  changedby                   varchar(50) not null
) Type=InnoDB
alter table mailinglist_player_matrix add foreign key (player_id) references player(player_id)
alter table mailinglist_player_matrix add foreign key (mailinglist_id) references mailinglist(mailinglist_id)
alter table mailinglist_player_matrix add unique index (player_id, mailinglist_id)
